<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * @test
     * this will check if the api runs successfully
     *
     * @return void
     */
    public function check_newsletter_api_run_successfully()
    {
        // first, we need to generate a CSRF key
        $csrf = csrf_token();

        $response = $this->post('/api/newsletter/join', [], [
            "X-CSRF-TOKEN" => $csrf
        ]);

        $response->assertStatus(200);
    }


    /**
     * @test
     * this will check if the api runs successfully
     *
     * @return void
     */
    public function check_generate_token_api()
    {
        $response = $this->get('/api/token');

        $response->assertStatus(200);
    }
}
