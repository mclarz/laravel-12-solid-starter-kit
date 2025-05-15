<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'jd@gmail.com',
        'password' => 'password',
        'confirm_password' => 'password',
    ]);
    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'John Doe',
                'email' => 'jd@gmail.com',
            ]
        ]);

    expect(User::where('email', 'jd@gmail.com')->exists())->toBeTrue();
});

it('reject register with invalid email', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'password',
        'confirm_password' => 'password',
    ]);
    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('can login a user with valid username and password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'accessToken',
                'token_type',
            ]
        ]);
});


it('can logout an authenticated user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson('/api/logout');

    $response->assertOk()
        ->assertJson([
            'message' => 'Logged out successfully',
        ]);
});
