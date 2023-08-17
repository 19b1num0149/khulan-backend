<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMemberCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'member_id',
        'description',
    ];

    public function member()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
