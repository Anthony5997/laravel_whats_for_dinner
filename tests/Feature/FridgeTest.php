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

    public function test_get_fridge()
    {
        $user = $this->postJson('api/auth/register', [
            'nickname' => 'Antho',
            'email' => 'antho@test.com',
            'password' => 'azertyui'
        ]);


        $user = new User($user['user']);
        
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/fridge');
        $response->assertOk();
        var_dump($response->content());
    }
}
