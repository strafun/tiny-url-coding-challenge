<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class ProductCRUDTest extends TestCase
{
    private Model $product;
    /**
     * A basic feature test example.
     */
    public function test_list(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_insert_product(): void
    {
        $response = $this->post('/products');

        $response->assertStatus(201);
    }

    public function test_update_product(): void
    {

        $response = $this->put('/products/' . $this->product->getKey());

        $response->assertStatus(200);
    }

    public function test_delete_product(): void
    {

        $response = $this->delete('/categories/'  . $this->product->getKey());

        $response->assertStatus(200);
    }

}
