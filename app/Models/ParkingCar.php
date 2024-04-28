<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingCar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id', 
        'parking_id',
        'car_number',
        'ordered_at',
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
