<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupJoinRequest extends Model
{
    protected $fillable = [
        'user_id', 'group_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    }
