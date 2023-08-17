<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Event extends Model
{
    use HasFactory;

    protected $table = 'group_events';

    protected $fillable = [
        'group_id',
        'name',
        'description',
        'date',
        'created_at',
        'creator_id',
        'location',
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }
    
    public function creator(){
        return $this->belongsTo(User::class);
    }
}
