<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_text',
        'content_id',
        'read_at',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
