<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'description',
        'date',
        'created_at',
        'creator_id',
        'location',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    // Relationtiops
    public function itineraries(): HasMany
    {
        return $this->hasMany(GroupEventItinerary::class, 'event_id', 'id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(GroupEventMember::class, 'event_id', 'id');
    }
}
