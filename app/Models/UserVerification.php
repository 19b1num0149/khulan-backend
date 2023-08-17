<?php

namespace App\Models;

use App\Events\EmailVerified;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'saved' => EmailVerified::class,
    ];
}
