<?php

namespace App\Models;

use App\Events\UserRegistered;
use App\Models\UserCar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon; // Import Carbon for date/time operations

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'address',
        'birthday',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function parkingCars()
    {
        return $this->hasMany(ParkingCar::class);
    }

    public function getInvoice()
    {
        $invoices1 = $this->parkingCars()->where('is_active', 1);
        $invoices2 = $this->parkingCars()->where('is_active', 1);
        $invoices3 = $this->parkingCars()->where('is_active', 1);
    
        $ordered = $invoices1->whereNotNull('ordered_at')
                              ->whereNull('parked_at')
                              ->whereNull('paid_at')
                              ->whereNull('order_cancelled_at')
                              ->first();
    
        
        $parked = $invoices3->whereNotNull('parked_at')
                           ->whereNull('paid_at')
                           ->first();
            
        $cancelCost = 0;
            if ($parked) {
            $orderCost = 0;
            $orderDuration = 0;
            
            if ($parked->ordered_at) {
                $orderTime = Carbon::parse($parked->ordered_at);
                $parkedTime = Carbon::parse($parked->parked_at);
                $orderDuration = $orderTime->diffInMinutes($parkedTime);
                $orderCost = $orderDuration * 50;
            }
    
            $parkedTime = Carbon::parse($parked->parked_at);
            $currentTime = Carbon::now();
            $parkedDuration = $parkedTime->diffInMinutes($currentTime);
            $parkedCost = ($parkedDuration * $parked->parking->payment_per_hour / 60); 
            return [
                'car_number' => $parked->car_number ?? null,
                'order_duration' => $orderDuration,
                'order_cost' => $orderCost,
                'parked_duration' => $parkedDuration,
                'parked_cost' => $parkedCost,
                'total_cost' => $parkedCost + $orderCost
            ];
        } elseif ($ordered) {
            $orderTime = Carbon::parse($ordered->ordered_at);
            $cancelTime = Carbon::parse($ordered->order_cancelled_at);
            $orderDuration = $orderTime->diffInMinutes($cancelTime);
            $cancelCost = $orderDuration * 50;
            return [
                'car_number' => $ordered->car_number ?? null,
                'order_duration' => $orderDuration,
                'order_cost' => $cancelCost,
            ];
        }
    }
    
}
