<?php

namespace App\Listeners;

use App\Events\EmailVerified;
use App\Models\User;
use Carbon\Carbon;

class UpdateUserEmailVerification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(EmailVerified $event): void
    {
        $verified = $event->verified;
        
        if(!is_null($verified->used_at)) {
            $user = User::where('email', $verified->email)->whereNull('email_verified_at')->first();
            $user->email_verified_at = Carbon::now();
            $user->active = 1;
            $user->save();
        }

    }
}
