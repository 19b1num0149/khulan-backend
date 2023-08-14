<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_and_Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'founded_year',
        'phone',
        'mail',
        'service_name',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
