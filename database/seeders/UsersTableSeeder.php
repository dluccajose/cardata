<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'created_at' => '2022-01-15 17:14:05',
                'email' => 'super@admin.com',
                'email_verified_at' => NULL,
                'id' => 1,
                'name' => 'admin',
                'password' => '$2y$10$Gw8XNu4Bfee3cufpsMUk6u1bmy6kadsfyCSxYyGSTyF4proqjpO1K',
                'remember_token' => NULL,
                'updated_at' => '2022-01-15 17:14:05',
            ),
        ));
        
        
    }
}