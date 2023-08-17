<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_services extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'founded_year',
        'service_name',
    ];
    
}
