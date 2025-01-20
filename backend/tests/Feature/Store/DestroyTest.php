<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_store(): void
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

        $store = $this->withHeader('Authorization', 'Bearer' . $login->json('token'))->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
        ]);

        $store->assertStatus(201);

        $id = $store->json('store')['id'];

        $storeDeleted = $this->withHeader('Authorization', 'Bearer' . $login->json('token'))->delete('api/store/' . $id);

        $storeDeleted->assertStatus(200);
    }

    public function test_delete_store_incorrect_id(): void
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

        $store = $this->withHeader('Authorization', 'Bearer' . $login->json('token'))->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
        ]);

        $store->assertStatus(201);

        $storeDeleted = $this->withHeader('Authorization', 'Bearer' . $login->json('token'))->delete('api/store/xxxx');

        $storeDeleted->assertStatus(404);
    }
}
