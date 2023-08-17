<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Member_Coupon extends Model
{
    use HasFactory;

    protected $table = 'group_member_coupons';

    protected $fillable = [
        'group_id',
        'member_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
