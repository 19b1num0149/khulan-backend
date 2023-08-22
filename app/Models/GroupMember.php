<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'member_id',
        'activity_id',
        'role_id',
        'joined_at',
        'left_at',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function userPoint()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function scopeJoined(Builder $query): void
    {
        $query->orderBy('joined_at', 'DESC');
    }

    public function scopeRank(Builder $query): void
    {
        $query->orderBy('user_points.point', 'DESC');
    }

    //     public function scopeStructure(Builder $query): void
    //     {
    //         $query->orderBy('joined_at', 'DESC');
    //     }
}
