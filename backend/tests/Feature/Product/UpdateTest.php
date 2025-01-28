<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_product(): void
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

        $productId = $product->json('product')['id'];

        $file2 = UploadedFile::fake()->image('avatar.jpg');

        $productViewed = $this->put('api/product/'. $productId, [
            'image' => $file2,
            'name' => 'Produto 2',
            'description' => 'Produto peba',
            'price' => 11.99,
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(200);
    }

    public function test_update_product_without_image(): void
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

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        $productId = $product->json('product')['id'];

        $productViewed = $this->put('api/product/'. $productId, [
            'name' => 'Produto 2',
            'description' => 'Produto peba',
            'price' => 11.99,
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(200);
    }

    public function test_update_product_incorrect_id(): void
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

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        $productViewed = $this->put('api/product/xxxxx', [
            'name' => 'Produto 2',
            'description' => 'Produto peba',
            'price' => 11.99,
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(404);
    }

    public function test_update_product_without_fields(): void
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

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        $productId = $product->json('product')['id'];

        $productViewed = $this->put('api/product/'. $productId, [
            'description' => 'Produto peba',
            'price' => 11.99,
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(302);

        $productViewed = $this->put('api/product/'. $productId, [
            'name' => 'Produto 2',
            'price' => 11.99,
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(302);

        $productViewed = $this->put('api/product/'. $productId, [
            'name' => 'Produto 2',
            'description' => 'Produto peba',
            'store_id' => $storeId,
        ]);

        $productViewed->assertStatus(302);

        $productViewed = $this->put('api/product/'. $productId, [
            'name' => 'Produto 2',
            'description' => 'Produto peba',
            'price' => 11.99,
        ]);

        $productViewed->assertStatus(302);

        $productViewed = $this->put('api/product/'. $productId);

        $productViewed->assertStatus(302);
    }

    
}
