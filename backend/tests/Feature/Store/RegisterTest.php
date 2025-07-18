<?php

namespace Tests\Feature\Store;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_store(): void
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

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $store = $this->post('/api/store', [
            'image' => $file,
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(201);
    }

    public function test_create_store_without_image(): void
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
    }

    public function test_create_store_without_name(): void
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
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(302);
    }

    public function test_create_store_without_description(): void
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
            'name' => 'loja y',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(302);
    }

    public function test_create_store_without_whatsapp(): void
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
            'name' => 'loja y',
            'description' => 'aodjaos',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(302);
    }

    public function test_should_cant_create_store_double_whatsapp(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertCreated();

        $newuser = User::factory()->create();

        $this->actingAs($newuser);

        $store = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/store', [
            'name' => 'loja y',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
            'chave_pix' => 'chave-pix-12345',
        ]);

        $store->assertStatus(422);
        $store->assertJson([
            'message' => 'The whatsapp has already been taken.',
        ]);
    }

    public function test_create_store_without_name_and_description_and_whatsapp_and_chave_pix(): void
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

        $store = $this->post('/api/store');

        $store->assertStatus(302);
    }
}
