<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\EmailVerified;

class ClientVerification extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'saved' => EmailVerified::class
    ];
}
