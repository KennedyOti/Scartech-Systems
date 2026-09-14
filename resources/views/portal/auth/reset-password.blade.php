<x-guest-layout title="Choose a new password">
    <h1 class="text-2xl font-semibold tracking-[-0.02em]">Choose a new password</h1>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-form.input name="email" label="Email address" type="email" :value="$request->email" required autocomplete="username" />
        <x-form.input name="password" label="New password" type="password" required autofocus autocomplete="new-password" />
        <x-form.input name="password_confirmation" label="Confirm new password" type="password" required autocomplete="new-password" />

        <x-button type="submit" class="w-full">Reset password</x-button>
    </form>
</x-guest-layout>
