<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\City;
use App\Models\Brand;
use App\Models\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ToCollection;

class CityCarImport implements ToCollection
{
    private $carsCount = 0;
    
    private $newCarsCount = 0;

    public function getCarsCount()
    {
        return $this->carsCount;
    }

    public function getNewCarsCount()
    {
        return $this->newCarsCount;
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        $header = $rows[0];

        $cityString = $this->getCityFromString($header[0]);

        if (!$cityString) return false;

        if (!$city = City::where('name', $cityString)->first()) {
            $city = City::create([
                'name' => $cityString,
                'code' => Str::slug($cityString, '-', 'es'),
                'state_id' => 1,
            ]);
        };

        $dataRows = $rows->splice(3);

        $this->carsCount = $dataRows->count();

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
                
                $car->cities()->attach($city);

                $this->newCarsCount++;
            }
        } 
    }

    private function getCityFromString(string $string)
    {
        $start = strpos($string, 'Municipio: ') + 11;

        $end = strpos($string, ' | Grupo', $start);

        $city = substr($string, $start, $end - $start);

        return trim($city);
    }
}
