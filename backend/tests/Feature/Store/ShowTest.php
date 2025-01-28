<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_store(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);

        $login = $this->post('/api/login', [
            'email' => 'test@example.com',
        ]);

        $login->assertStatus(200);

        $login->assertExactJsonStructure(['token']);

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
        ]);

        $store->assertStatus(201);
        
        $id = $store->json('store')['id'];
        
        $storeViewed = $this->get('api/store/'.$id);

        $storeViewed->assertStatus(200);
    }

    public function test_show_store_incorrect_id(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);

        $login = $this->post('/api/login', [
            'email' => 'test@example.com',
        ]);

        $login->assertStatus(200);

        $login->assertExactJsonStructure(['token']);

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
        ]);

        $store->assertStatus(201);
        
        $storeViewed = $this->get('api/store/xxxx');

        $storeViewed->assertStatus(404);
    }

}
