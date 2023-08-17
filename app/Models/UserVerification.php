<?php

namespace App\Models;

use App\Events\EmailVerified;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientVerification extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'saved' => EmailVerified::class,
    ];
}
