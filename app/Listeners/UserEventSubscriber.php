<?php

namespace App\Listeners;

use App\Events\ResendCode;
use App\Events\UserRegistered as UserRegisteredEvent;
use App\Mail\CodeResent;
use App\Mail\UserRegistered as UserRegisteredMail;
use App\Models\UserVerification;
use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserEventSubscriber
{
    protected $code;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->code = rand(100000, 999999);
    }

    protected function sendEmail($event, $type): void
    {
        $user = $event->user;

        $verification = new UserVerification;
        $verification->email = $user->email;
        $verification->code = $this->code;
        $verification->expired_at = Carbon::now()->addMinutes(5);
        $verification->save();

        $numbersArray = str_split($this->code);
        $hashedCode = Hash::make($this->code);

        if ($type == 'registered') {
            Mail::to($user->email)->send(new UserRegisteredMail($user->name,
                $numbersArray,
                $hashedCode));
        }

        if ($type == 'newcode') {
            Mail::to($user->email)->send(new CodeResent($user->name,
                $numbersArray,
                $hashedCode));
        }

    }

    /**
     * Handle user Registered Event.
     */
    public function handleUserRegistered($event): void
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
            UserRegisteredEvent::class,
            [UserEventSubscriber::class, 'handleUserRegistered']
        );

        $events->listen(
            ResendCode::class,
            [UserEventSubscriber::class, 'handleResendCode']
        );
    }
}
