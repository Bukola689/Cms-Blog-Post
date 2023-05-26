<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{

    private $user;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
       $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->email)->send(new WelcomeMail($event->user));
    }
}
