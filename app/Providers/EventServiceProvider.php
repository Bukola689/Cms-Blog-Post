<?php

namespace App\Providers;

use App\Listeners\SendWelcomeEmail;
use App\Subscriber\Model\Profile\ChangePasswordSubscriber;
use App\Subscriber\Model\Profile\ProfileSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Register::class => [
            SendWelcomeEmail::class,
        ],
        
    ];

         protected $subscriber = [
            ProfileSubscriber::class,
            ChangePasswordSubscriber::class,
         ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
