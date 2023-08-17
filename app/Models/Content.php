<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'content',
        'created_at',
        'point',
        'updated_at',
        'type',
        'slug',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
