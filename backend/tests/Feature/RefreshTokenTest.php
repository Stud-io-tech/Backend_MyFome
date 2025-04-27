<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RefreshTokenTest extends TestCase
{
    use RefreshDatabase;


    public function test_should_returns_new_access_token(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
            ]);

        $this->assertDatabaseHas('refresh_tokens', [
            'user_id' => $user->id,
            'expires_at' => now()->addDays(config('refreshtoken.expiration_days')),
        ]);

        $refreshToken = $response->json('refresh_token');

        $response = $this->post('/api/refresh-token', [
            'refresh_token' => $refreshToken,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
            ]);
    }

    public function test_should_cant_create_new_access_token_without_refresh_token_field(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/refresh-token');

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'refresh_token' => 'The refresh token field is required.',
            ]);

        $this->assertDatabaseMissing('refresh_tokens', [
            'user_id' => null,
            'expires_at' => now()->addDays(config('refreshtoken.expiration_days')),
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/refresh-token', [
            'refresh_token' => '',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'refresh_token' => 'The refresh token field is required.',
            ]);

        $this->assertDatabaseMissing('refresh_tokens', [
            'user_id' => null,
            'expires_at' => now()->addDays(config('refreshtoken.expiration_days')),
        ]);
    }

    public function test_should_cant_create_new_access_token_with_refresh_token_expired(): void
    {


        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
            ]);

        $this->assertDatabaseHas('refresh_tokens', [
            'user_id' => $user->id,
            'expires_at' => now()->addDays(config('refreshtoken.expiration_days')),
        ]);

        $refreshToken = $response->json('refresh_token');

        Carbon::setTestNow(now()->addDays(config('refreshtoken.expiration_days') + 1));

        $response = $this->post('/api/refresh-token', [
            'refresh_token' => $refreshToken,
        ]);

        $response->assertUnauthorized()
            ->assertJson([
                'message' => 'Invalid refresh token.',
            ]);
    }
}
