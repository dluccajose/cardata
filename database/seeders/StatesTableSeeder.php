<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'code' => 'PORTUGUESA',
                'created_at' => NULL,
                'id' => 1,
                'name' => 'PORTUGUESA',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}