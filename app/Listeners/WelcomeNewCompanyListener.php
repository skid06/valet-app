<?php

namespace App\Listeners;

use App\Events\NewCompanyHasSubscribedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\WelcomeNewOwnerMail;
use Mail;

class WelcomeNewCompanyListener
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
        info("WelcomeNewCompanyListener Triggered");
        Mail::to($event->user->email)->send(new WelcomeNewOwnerMail($event->user));
    }
}
