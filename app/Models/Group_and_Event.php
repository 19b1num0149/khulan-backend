<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_and_Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'description',
        'date',
        'created_at',
        'creator',
        'location',
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}