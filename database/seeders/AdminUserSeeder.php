<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the portal administrator from config('auth.admin').
     *
     * Re-running the seeder keeps an existing admin's password, so a password changed in the portal
     * is not reset. Outside production a missing ADMIN_PASSWORD falls back to "password".
     */
    public function run(): void
    {
        $config = config('auth.admin');
        $password = $config['password'];

        if (blank($password)) {
            if (app()->isProduction()) {
                throw new RuntimeException('Set ADMIN_PASSWORD in .env before seeding the admin user in production.');
            }

            $password = 'password';
        }

        $admin = User::firstOrNew(['email' => $config['email']]);

        if (! $admin->exists) {
            $admin->name = $config['name'];
            $admin->password = $password;
        }

        $admin->forceFill([
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => $admin->email_verified_at ?? now(),
        ])->save();

        $this->command?->info("Admin user: {$admin->email}");
    }
}
