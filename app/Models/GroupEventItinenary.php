<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupEventItinenary extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'description',
        'title',
    ];

    public function event()
    {
        return $this->belongsTo(Group_and_Event::class);
    }
}
