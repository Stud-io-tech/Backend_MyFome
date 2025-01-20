<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_store(): void
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

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $store = $this->withHeader('Authorization', 'Bearer'. $login->json('token'))->post('/api/store', [
            'image' => $file,
            'name' => 'loja x',
            'description' => 'descrição',
        ]);

        $store->assertStatus(201);

        $id = $store->json('store')['id'];

        $file2 = UploadedFile::fake()->image('avatar2.jpg');

        $storeUpdated = $this->withHeader('Authorization', 'Bearer'. $login->json('token'))->put('api/store/' . $id, [
            'image' => $file2,
            'name' => 'loja y',
            'description' => 'description',
        ]);

        $storeUpdated->assertStatus(200);
    }

    public function test_update_store_without_image_with_update_image(): void
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

        $id = $store->json('store')['id'];

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar2.jpg');

        $storeUpdated = $this->post('api/store/' . $id, [
            '_method' => 'PUT',
            'image' => $file,
            'name' => 'loja y',
            'description' => 'description',
        ]);

        $storeUpdated->assertStatus(200);
    }

    public function test_update_store_without_image_without_update_image(): void
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

        $id = $store->json('store')['id'];

        $storeUpdated = $this->post('api/store/' . $id, [
            '_method' => 'PUT',
            'name' => 'loja y',
            'description' => 'description',
        ]);

        $storeUpdated->assertStatus(200);
    }

    public function test_update_store_without_name(): void
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

        $id = $store->json('store')['id'];

        $storeUpdated = $this->post('api/store/' . $id, [
            '_method' => 'PUT',
            'description' => 'description',
        ]);

        $storeUpdated->assertStatus(302);
    }

    public function test_update_store_without_description(): void
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

        $id = $store->json('store')['id'];

        $storeUpdated = $this->post('api/store/' . $id, [
            '_method' => 'PUT',
            'name' => 'loja x',
        ]);

        $storeUpdated->assertStatus(302);
    }

    public function test_update_store_without_name_without_description(): void
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

        $id = $store->json('store')['id'];

        $storeUpdated = $this->post('api/store/' . $id, [
            '_method' => 'PUT',
        ]);

        $storeUpdated->assertStatus(302);
    }

    public function test_update_store_incorrect_id(): void
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

        $storeUpdated = $this->post('api/store/xxxxx', [
            '_method' => 'PUT',
            'name' => 'loja y',
            'description' => 'description',
        ]);

        $storeUpdated->assertStatus(404);
    }
}
