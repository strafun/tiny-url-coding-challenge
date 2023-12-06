<?php

namespace Tests\Feature;

use App\Jobs\SaveProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
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
        Queue::fake();
        $response = $this->post('/products', $this->getRequestData());
        Queue::assertPushed(SaveProduct::class);

        $response->assertStatus(302)->assertRedirect('/products');
    }

    public function test_update_product(): void
    {
        Queue::fake();

        $response = $this->put('/products/' . $this->product->getKey(), $this->getRequestData());
        Queue::assertPushed(SaveProduct::class);

        $response->assertStatus(302)->assertRedirect('/products');
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

    private function getRequestData()
    {
        return [
            'name' => fake()->word(),
            'category_id' => $this->product->category_id,
            'description' => fake()->words(10, true),
            'isTop' => true,
            'price' => fake()->numberBetween(1, 1000)
        ];
    }

}
