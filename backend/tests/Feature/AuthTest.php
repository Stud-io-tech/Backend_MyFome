<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_user_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);
    }

    public function test_cant_user_register_not_name_field(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(302);
    }

    public function test_cant_user_register_not_email_valid(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'test example',
            'email' => 'testexample',
        ]);

        $response->assertStatus(302);
    }

    public function test_cant_user_register_not_email_field(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'test example',
        ]);

        $response->assertStatus(302);
    }

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
}
