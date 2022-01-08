<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\City;
use App\Models\Brand;
use App\Models\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CityCarImport implements ToCollection
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        $header = $rows[0];

        $cityString = $this->getCityFromString($header[0]);

        $city = City::create(['name' => $cityString, 'state_id' => 1]);

        if (!$city = City::where('name', $cityString)->first()) {
            $city = City::create([
                'name' => $cityString,
                'code' => Str::slug($cityString, '-', 'es'),
            ]);
        };

        $dataRows = $rows->splice(3);

        foreach ($dataRows as $row) {

            if (!$row[2]) {
                continue;
            }
            
            if (!$brand = Brand::where('name', $row[2])->first()) {
                $brand = Brand::create([
                    'name' => $row[2],
                    'code' => Str::slug($row[2], '-', 'es'),
                ]);
            };

            if (!$model = Model::where('name', $row[3])->where('brand_id', $brand->id)->first()) {
                $model = Model::create([
                    'name' => $row[3], 
                    'brand_id' => $brand->id,
                    'code' => Str::slug($row[3], '-', 'es'),
                ]);
            };

            $car = Car::where('license_plate', $row[1])->first();

            if (!$car) {
                $car = Car::create([
                    'license_plate' => $row[1],
                    'owners_name' => $row[5],
                    'owners_uid' => $row[4],
                    'model_id' => $model->id,
                ]);
            }

            $car->cities()->attach($city);
        } 
    }

    private function getCityFromString(string $string)
    {
        $start = strpos($string, 'Municipio: ') + strlen('Municipio:');

        $end = strpos($string, '| Grupo', $start);

        $city = mb_substr($string, $start, $end - $start - 3, 'UTF-8');

        return $city;
    }
}
