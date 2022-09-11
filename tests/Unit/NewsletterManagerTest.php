<?php

namespace Tests\Unit;

use App\Exceptions\Newsletter\NewsletterEmailExists;
use App\Services\Newsletter\NewsletterManager;
use Illuminate\Support\Str;
use PharIo\Manifest\InvalidEmailException;
use Tests\TestCase;

class NewsletterManagerTest extends TestCase
{

    /**
     * this function will generate a random email which should be unique
     * @return string
     */
    public function generateRandomEmail(): string
    {
        // generate random email
        return Str::random(36) . "@" . Str::random(36) . ".com";
    }


    /**
     * @test
     * try to signup a new email address
     *
     * @return void
     */
    public function test_signup_email_with_newsletter_manager()
    {

        // generate an email address
        $emailAddress = $this->generateRandomEmail();

        // make a newsletter object
        $newsletterManager = new NewsletterManager($emailAddress);

        // try to join
        $result = $newsletterManager->joinSubscribers();

        // check if it done successfully
        $this->assertTrue($result);
    }


    /**
     * @test
     * test duplicate email which should trough exception
     *
     * @return void
     */
    public function test_duplicate_email_with_newsletter_manager()
    {

        // generate an email address
        $emailAddress = $this->generateRandomEmail();

        // make a newsletter object
        $newsletterManager = new NewsletterManager($emailAddress);
        $newsletterManager->joinSubscribers();

        $this->expectException(NewsletterEmailExists::class);

        // now, try to do it again
        $newsletterManager = new NewsletterManager($emailAddress);
        $newsletterManager->joinSubscribers();

    }


    /**
     * @test
     * Test empty email address with newsletter
     *
     * @return void
     */
    public function test_empty_email_with_newsletter_manager()
    {

        // generate an email address
        $emailAddress = $this->generateRandomEmail();

        $this->expectException(InvalidEmailException::class);

        // now, try to do it again
        $newsletterManager = new NewsletterManager("");
        $newsletterManager->joinSubscribers();

    }



    /**
     * @test
     * Test invalid email address with newsletter
     *
     * @return void
     */
    public function test_invalid_email_with_newsletter_manager()
    {

        // generate an email address
        $emailAddress = $this->generateRandomEmail();

        $this->expectException(InvalidEmailException::class);

        // now, try to do it again
        $newsletterManager = new NewsletterManager("a1@asdasdasd");
        $newsletterManager->joinSubscribers();

    }
}
