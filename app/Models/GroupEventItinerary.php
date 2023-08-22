<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupEventItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'description',
        'title',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(GroupEvent::class, 'event_id', 'id');
    }
}
