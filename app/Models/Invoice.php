<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'activity_id',
        'amount',
        'generated_at',
        'due_at',
        'canceled_at',
        'paid_at',
        'point',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
