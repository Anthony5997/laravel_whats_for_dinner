<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FridgeTest extends TestCase
{
    use RefreshDatabase;
  
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

    public function test_add_fridge_ingredient()
    {
     
        $user = $this->authenticateUser();
        
        Sanctum::actingAs($user['user']);
        $this->initDataInDatabase();
        

        $response = $this->postJson('/api/fridge/addIngredient', [
            "fridgeId"=> $user['fridge']->id,
            "ingredientId" => 1,
            "quantity" => 150,
            "unit" => 1,
        ]);
        $response->assertStatus(200);
    } 

    public function test_get_fridge()
    {
     
        $user = $this->authenticateUser();
        
        Sanctum::actingAs($user['user']);
        // $this->initDataInDatabase();
        
        $this->postJson('/api/fridge/addIngredient', [
            "fridgeId"=> $user['fridge']->id,
            "ingredientId" => 1,
            "quantity" => 150,
            "unit" => 1,
        ]);

        $response = $this->getJson('/api/fridge');
        $response->assertStatus(200);
    }

        // public function test_update_fridge_ingredient()
    // {
     
    //     $user = $this->authenticateUser();
        
    //     Sanctum::actingAs($user['user']);
    //     $this->initDataInDatabase();
        
    //     $response = $this->postJson('/api/fridge/updateIngredient', [
    //         "fridgeId"=> $user['fridge']->id,
    //         "ingredientId" => 1,
    //         "quantity" => 250,
    //         "unit" => 1,
    //     ]);
        
    //     $response->assertStatus(200);
    // }
}