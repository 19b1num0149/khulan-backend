<?php

namespace App\Listeners;

use App\Events\ClientRegistered as ClientRegisteredEvent;
use App\Events\ResendCode;
use App\Mail\ClientRegistered as ClientRegisteredMail;
use App\Mail\CodeResent;
use App\Models\ClientVerification;
use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientEventSubscriber
{
    protected $code;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->code = rand(1000, 9999);
    }

    protected function sendEmail($event, $type): void
    {
        $client = $event->client;

        $verification = new ClientVerification;
        $verification->email = $client->email;
        $verification->code = $this->code;
        $verification->expired_at = Carbon::now()->addMinutes(5);
        $verification->save();

        $numbersArray = str_split($this->code);
        $hashedCode = Hash::make($this->code);

        if ($type == 'registered') {
            Mail::to($client->email)->send(new ClientRegisteredMail($client->company_id,
                $client->name,
                $numbersArray,
                $hashedCode));
        }

        if ($type == 'newcode') {
            Mail::to($client->email)->send(new CodeResent($client->company_id,
                $client->name,
                $numbersArray,
                $hashedCode));
        }

    }

    /**
     * Handle Client Registered Event.
     */
    public function handleClientRegistered($event): void
    {
        $this->sendEmail($event, 'registered');
    }

    /**
     * Handle Resend Code Event.
     */
    public function handleResendCode($event): void
    {
        $this->sendEmail($event, 'newcode');
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            ClientRegisteredEvent::class,
            [ClientEventSubscriber::class, 'handleClientRegistered']
        );

        $events->listen(
            ResendCode::class,
            [ClientEventSubscriber::class, 'handleResendCode']
        );
    }
}
