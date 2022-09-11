<?php

namespace App\Events\Newsletter;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionHappened
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected string $emailAddress;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->emailAddress = $email;
    }


    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }
}
