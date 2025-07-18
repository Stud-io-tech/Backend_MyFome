<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChangeActiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_active_product(): void
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

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(201);

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        $productId = $product->json('product')['id'];

        $productChanged = $this->put('api/product/active/' . $productId);

        $productChanged->assertStatus(200);
    }

    public function test_change_active_product_incorrect_id(): void
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

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(201);

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        
        $productChanged = $this->put('api/product/active/xxxx');

        $productChanged->assertStatus(404);
    }
}
