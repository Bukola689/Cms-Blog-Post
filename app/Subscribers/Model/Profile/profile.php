<?php

namespace App\Subscriber\Model\Profile;

use App\Events\Profile\ProfileCreated;
use App\Listeners\Profile\ProfileListener;
use Illuminate\Events\Dispatcher;

class ProfileSubscriber
{
    public function profileSubscriber(Dispatcher $events)
    {
        $events->listen(ProfileCreated::class, ProfileListener::class);
    }
}