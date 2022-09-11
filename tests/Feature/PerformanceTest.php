<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PerformanceTest extends TestCase
{



    /**
     * @test
     * check for the CSRF key
     *
     * @return void
     */
    public function check_csrf_key(): void
    {

        $response = $this->getJson('/api/token');

        // check if we have result key
        $response->assertJsonStructure(["key"]);

    }


    /**
     * @test
     * this will try to make a request to server and then check if that return true
     *
     * @return void
     */
    public function check_newsletter_email_signup_successfully(): void
    {

        // generate random email
        $email = $this->generateRandomEmail();

        $response = $this->postJson('/api/newsletter/join', [
            "email" => $email
        ]);

        // check if we have result key
        $response->assertJson(["result" => true]);

    }


    /**
     * @test
     * now, try to duplicate email address
     *
     * @return void
     */
    public function check_newsletter_duplicate_email(): void
    {

        // generate random email
        $email = $this->generateRandomEmail();

        $this->postJson('/api/newsletter/join', [
            "email" => $email
        ]);

        $response = $this->postJson('/api/newsletter/join', [
            "email" => $email
        ]);

        // check if we have result key
        $response->assertJson(["result" => false]);

    }



    /**
     * @test
     * now, try to duplicate email address
     *
     * @return void
     */
    public function check_newsletter_invalid_email_address(): void
    {

        // generate random email
        $email = Str::random(32) . ".com";

        $response = $this->postJson('/api/newsletter/join', [
            "email" => $email
        ]);

        // check if we have result key
        $response->assertJson(["result" => false]);

    }


    /**
     * @test
     * now, try to duplicate email address
     *
     * @return void
     */
    public function check_newsletter_empty_email_address(): void
    {

        $response = $this->postJson('/api/newsletter/join', [

        ]);

        // check if we have result key
        $response->assertJson(["result" => false]);

    }


    /**
     * this function will generate a random email which should be unique
     * @return string
     */
    public function generateRandomEmail(): string
    {
        // generate random email
        return Str::random(36) . "@" . Str::random(36) . ".com";
    }
}
