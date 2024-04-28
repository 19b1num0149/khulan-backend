<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Parking; 
use App\Models\ParkingCar; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        User::factory(2)->create();

        // Seed parkings
        Parking::factory(10)->create(); 

        // ParkingCar::factory(20) -> create();
        
        }
}

