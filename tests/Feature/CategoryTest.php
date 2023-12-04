<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_categories(): void
    {
        Category::factory()->create();
        $response = $this->get('/categories');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'title',
                'id'
            ]
        ]);
    }

    public function test_create_category(): void
    {
        $response = $this->get('/categories/create');

        $response->assertStatus(200);
    }

    public function test_insert_category(): void
    {
        $category = Category::factory()->make();
        $this->assertDatabaseCount('categories', 0);
        $response = $this->post('/categories', $category->getAttributes());
        $this->assertDatabaseCount('categories', 1);

        $response->assertStatus(302)->assertRedirect('/');
    }
}
