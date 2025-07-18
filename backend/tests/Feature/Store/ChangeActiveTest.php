<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeActiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_active_store(): void
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

        $login->assertExactJsonStructure(['access_token', 'refresh_token']);

        $store = $this->withHeader('Authorization', 'Bearer' . $login->json('access_token'))->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(201);

        $id = $store->json('store')['id'];

        $storeChanged = $this->withHeader('Authorization', 'Bearer' . $login->json('access_token'))->put('api/store/active/' . $id);

        $storeChanged->assertStatus(200);
    }

    public function test_change_active_store_incorrect_id(): void
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

        $login->assertExactJsonStructure(['access_token', 'refresh_token']);

        $store = $this->withHeader('Authorization', 'Bearer' . $login->json('access_token'))->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(201);

        $storeChanged = $this->withHeader('Authorization', 'Bearer' . $login->json('access_token'))->put('api/store/active/xxxx');

        $storeChanged->assertStatus(404);
    }
}
