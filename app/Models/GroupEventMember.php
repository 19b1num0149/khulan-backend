<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEventMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'event_id',
        'member_id',
        'joined_at',
    ];

    public function event()
    {
        return $this->belongsTo(Group_and_Event::class);
    }
}
