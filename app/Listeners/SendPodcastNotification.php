<?php

namespace App\Listeners;

use App\Events\NewCompanyHasSubscribedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPodcastNotification
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
     * @param  \App\Events\NewCompanyHasSubscribedEvent  $event
     * @return void
     */
    public function handle(NewCompanyHasSubscribedEvent $event)
    {
        //
    }
}
