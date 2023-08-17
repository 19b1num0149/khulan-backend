<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Point extends Model
{
    use HasFactory;

    protected $table = 'user_points';

    protected $fillable = [
        'group_id',
        'user_id',
        'point',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }
}
