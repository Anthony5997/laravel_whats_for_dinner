<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');
        
    //     $response->assertStatus(200);
    // }
    
    public function setUp(): void
    {
        parent::setUp();
        $this->initDatabase();
    }

    public function tearDown(): void
    {
        $this->resetDatabase();
        parent::tearDown();
    }

 

    public function test_get_recipe()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/recipe/potentialRecipes');

        $response->assertOk();
    }

}
