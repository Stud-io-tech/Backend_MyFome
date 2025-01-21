<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product(): void
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
        ]);

        $store->assertStatus(201);

        $storeId = $store->json('store')['id'];

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $product = $this->post('api/product', [
            'image' => $file,
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);
    }

    public function test_create_product_without_image(): void
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
    }

    public function test_create_product_without_required_fields(): void
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
        ]);

        $store->assertStatus(201);

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(302);

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(302);

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'store_id' => $storeId,
        ]);

        $product->assertStatus(302);

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99
        ]);

        $product->assertStatus(302);

        $product = $this->post('api/product');

        $product->assertStatus(302);
    }
}
