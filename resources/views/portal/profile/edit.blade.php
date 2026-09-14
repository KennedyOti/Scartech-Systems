<x-app-layout title="Your profile">
    <x-portal::page-header title="Your profile" description="Update your name, email address and password." />

    <div class="max-w-2xl space-y-6">
        <x-portal::card title="Profile information">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <x-form.input name="name" label="Name" :value="$user->name" required autocomplete="name" />
                <x-form.input name="email" label="Email address" type="email" :value="$user->email" required autocomplete="username" />

                <div class="flex justify-end">
                    <x-button type="submit">Save profile</x-button>
                </div>
            </form>
        </x-portal::card>

        <x-portal::card title="Change password" description="Use a long password that you do not use anywhere else.">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form.input name="current_password" label="Current password" type="password" bag="updatePassword" required autocomplete="current-password" />
                <x-form.input name="password" label="New password" type="password" bag="updatePassword" required autocomplete="new-password" />
                <x-form.input name="password_confirmation" label="Confirm new password" type="password" bag="updatePassword" required autocomplete="new-password" />

                <div class="flex justify-end">
                    <x-button type="submit">Change password</x-button>
                </div>
            </form>
        </x-portal::card>

        <x-portal::card title="Delete account" description="Permanently remove your portal account. Projects and products you added stay on the website.">
            <form
                method="POST"
                action="{{ route('profile.destroy') }}"
                x-data
                @submit="if (! confirm('Delete your portal account? You will be signed out and cannot undo this.')) $event.preventDefault()"
                class="space-y-5"
            >
                @csrf
                @method('DELETE')

                <x-form.input name="password" label="Confirm with your password" type="password" bag="userDeletion" required autocomplete="current-password" id="field-delete-password" />

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-danger/30 bg-white px-5 text-[0.9375rem] font-semibold text-danger transition-colors duration-[120ms] hover:border-danger hover:bg-danger/5">
                        <x-lucide-trash-2 class="size-[1.125rem]" aria-hidden="true" />
                        Delete account
                    </button>
                </div>
            </form>
        </x-portal::card>
    </div>
</x-app-layout>
