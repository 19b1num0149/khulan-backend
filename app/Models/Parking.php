<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parking extends Model
{

    use HasFactory;
    public function parkingCars()
    {
        return $this->hasMany(ParkingCar::class);
    }

    public function getFreeSpaceAttribute()
    {
        // Calculate the number of cars parked
        $numberOfCarsParked = $this->parkingCars()->where('is_active', true)->count();
        
        // Calculate the number of free spaces
        $freeSpace = $this->capacity - $numberOfCarsParked;
        
        return $freeSpace;
    }
}
