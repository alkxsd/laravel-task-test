<?php

use App\Models\User;

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);

    $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
});


it('can log in a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);
});
