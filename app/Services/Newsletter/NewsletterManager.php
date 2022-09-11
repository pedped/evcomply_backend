<?php

namespace App\Services\Newsletter;

use App\Events\Newsletter\NewsletterSubscriptionHappened;
use App\Exceptions\Newsletter\NewsletterEmailExists;
use App\Mail\NewsletterSignup;
use App\Models\Newsletter\NewsletterEmail;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\InvalidEmailException;

/**
 * this class will handle the newsletter system
 */
class NewsletterManager
{

    /**
     * email address used for action
     * @var
     */
    private $emailAddress;

    /**
     * @param $emailAddress the email address used for this class action
     */
    public function __construct($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * by this option, we will join the constructor email address
     * to our newsletter system
     * @return bool
     * @throws NewsletterEmailExists|InvalidEmailException
     */
    public function joinSubscribers(): bool
    {
        // we have to check fo the email address and see if that is
        // valid email address
        if (!filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        // the email address is valid, check if the email address is not exists in our database
        $existsStatus = NewsletterEmail::emailExistsInSystem($this->emailAddress);
        $activeStatus = NewsletterEmail::emailIsActive($this->emailAddress);
        if ($existsStatus &&
            $activeStatus) {
            // email address already exists and active in database
            throw new NewsletterEmailExists();
        }

        // the email is not exists or it is not active, if that is exists,
        // and it is not active, we have to activate that
        if ($existsStatus && !$activeStatus) {
            NewsletterEmail::activateEmailAddress($this->emailAddress);
        } else {
            // the email is not exists in database, we have to add that
            NewsletterEmail::addEmailAddress($this->emailAddress);
        }

        // now, we have to send the signup message to the user
        $this->sendSignupMessage($this->emailAddress);

        // everything done, we have to send true as a success result
        return true;
    }

    /**
     * this function will send a message to the user
     * @param string $emailAddress
     * @return void
     */
    private function sendSignupMessage(string $emailAddress): void
    {
        NewsletterSubscriptionHappened::dispatch($emailAddress);
    }
}
