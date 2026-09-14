<?php

use App\Models\User;
use Database\Seeders\AdminUserSeeder;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->admin()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->admin()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users without the admin role can not authenticate', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('a signed-in user without the admin role is refused the portal', function (string $url) {
    $this->actingAs(User::factory()->create())->get($url)->assertForbidden();
})->with(['/portal', '/portal/projects', '/portal/products', '/portal/profile']);

test('the seeded admin can sign in to the dashboard', function () {
    config(['auth.admin.email' => 'owner@example.com', 'auth.admin.password' => 'seeded-secret']);

    $this->seed(AdminUserSeeder::class);

    $this->post('/login', [
        'email' => 'owner@example.com',
        'password' => 'seeded-secret',
    ])->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->get(route('dashboard'))->assertOk();
});

test('users can logout', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
