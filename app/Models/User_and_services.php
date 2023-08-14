<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_and_services extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'description',
        'founded_year',
        'service_name',
    ];
    
}
