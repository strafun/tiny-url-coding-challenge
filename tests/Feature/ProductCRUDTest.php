<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCRUDTest extends TestCase
{
    use RefreshDatabase;
    private Model $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

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
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('products_archive', 0);

        $response = $this->delete('/products/'  . $this->product->getKey());

        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('products_archive', 1);

        $response->assertStatus(302)->assertRedirect('/products');
    }

}
