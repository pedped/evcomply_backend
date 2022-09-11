<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @test
     * A basic test example.
     *
     * @return void
     */
    public function check_web_app_run_successfull()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


}
