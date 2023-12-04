<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductSortListTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_list(): void
    {
        $response = $this->get('/product-list');

        $response->assertStatus(200);
    }
}
