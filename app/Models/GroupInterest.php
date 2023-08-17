<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'interest_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
