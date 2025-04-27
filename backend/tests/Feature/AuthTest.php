<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_user_login(): void
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
    }

    public function test_cant_user_login_not_register(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(404);
    }

    public function test_cant_user_login_not_email(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'testexample',
        ]);

        $response->assertStatus(302);
    }

    public function test_can_get_user_logged(): void
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

        $login->assertExactJsonStructure([
            'access_token',
            'refresh_token',
        ]);

        $token = $login->json()['access_token'];

        $response = $this->get('/api/user', [
            'authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'image',
                'active',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
