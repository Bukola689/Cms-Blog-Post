<?php

namespace App\Subscriber\Model\Profile;

use App\Events\Profile\ChangePasswordCreated;
use App\Listeners\Profile\ChangePasswordListener;
use Illuminate\Events\Dispatcher;

class ChangePasswordSubscriber
{
    public function ChangePasswordSubscriber(Dispatcher $events)
    {
        $events->listen(ChangePasswordCreated::class, ChangePasswordListener::class);
    }
}