<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user who can sign in to the admin portal';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = text(label: 'Name', required: true);

        $email = text(
            label: 'Email address',
            required: true,
            validate: fn (string $value): ?string => Validator::make(
                ['email' => $value],
                ['email' => ['email', 'unique:users,email']],
            )->errors()->first('email') ?: null,
        );

        $password = password(
            label: 'Password',
            required: true,
            validate: fn (string $value): ?string => Validator::make(
                ['password' => $value],
                ['password' => [Password::defaults()]],
            )->errors()->first('password') ?: null,
        );

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->forceFill([
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ])->save();

        $this->components->info("Admin user {$email} created. Sign in at ".route('login'));

        return self::SUCCESS;
    }
}
