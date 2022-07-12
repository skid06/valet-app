<?php

namespace App\Providers;

use App\Events\NewUserAssignedToCompanyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WelcomeNewUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewUserAssignedToCompanyEvent  $event
     * @return void
     */
    public function handle(NewUserAssignedToCompanyEvent $event)
    {
        //
    }
}
