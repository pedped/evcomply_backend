<?php

namespace App\Listeners\Newsletter;

use App\Events\Newsletter\NewsletterSubscriptionHappened;
use App\Listeners\App;
use App\Mail\NewsletterSignup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterSignupNotification
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * @param App\Events\Newsletter\NewsletterSubscriptionHappened $event
     * @return void
     */
    public function handle(NewsletterSubscriptionHappened $event)
    {
        Mail::to($event->getEmailAddress())->queue(new NewsletterSignup());
    }
}
