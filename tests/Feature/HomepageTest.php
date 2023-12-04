<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
