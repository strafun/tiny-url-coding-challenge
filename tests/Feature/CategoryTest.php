<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_list_categories(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
    }

    public function test_create_category(): void
    {
        $response = $this->get('/categories/create');

        $response->assertStatus(200);
    }

    public function test_insert_category(): void
    {
        $response = $this->post('/categories');

        $response->assertStatus(201);
    }
}
