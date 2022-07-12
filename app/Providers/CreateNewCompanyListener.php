<?php

namespace App\Providers;

use App\Providers\NewCompanyHasSubscribedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateNewCompanyListener
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
     * @param  \App\Providers\NewCompanyHasSubscribedEvent  $event
     * @return void
     */
    public function handle(NewCompanyHasSubscribedEvent $event)
    {
        //
    }
}
