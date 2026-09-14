<?php

use App\Models\User;

test('public registration is disabled for the admin portal', function () {
    $this->get('/register')->assertNotFound();

    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNotFound();

    $this->assertGuest();
    expect(User::count())->toBe(0);
});

test('an admin user can be created from the console', function () {
    $this->artisan('app:create-admin-user')
        ->expectsQuestion('Name', 'Portal Admin')
        ->expectsQuestion('Email address', 'admin@example.com')
        ->expectsQuestion('Password', 'a-long-secure-password')
        ->assertSuccessful();

    $user = User::firstWhere('email', 'admin@example.com');

    expect($user)->not->toBeNull()
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and($user->isAdmin())->toBeTrue();
});
