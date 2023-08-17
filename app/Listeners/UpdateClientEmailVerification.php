<?php

namespace App\Listeners;

use App\Events\EmailVerified;
use App\Models\Client;
use Carbon\Carbon;

class UpdateClientEmailVerification
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

        if (! is_null($verified->used_at)) {
            $client = Client::where('email', $verified->email)->whereNull('email_verified_at')->first();
            $client->email_verified_at = Carbon::now();
            $client->active = 1;
            $client->save();
        }

    }
}
