<?php

namespace App\Providers;

use App\Providers\NewUserAssignedToCompanyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WelcomeNewUserListener
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
     * @param  \App\Providers\NewUserAssignedToCompanyEvent  $event
     * @return void
     */
    public function handle(NewUserAssignedToCompanyEvent $event)
    {
        //
    }
}
