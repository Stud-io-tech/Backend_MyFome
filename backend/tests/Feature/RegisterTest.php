<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_user_register_with_image(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'image' => 'string',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'id',
                'image',
                'updated_at',
                'created_at',
            ]
        ]);
    }

    public function test_can_user_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'id',
                'updated_at',
                'created_at',
            ]
        ]);
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
}
