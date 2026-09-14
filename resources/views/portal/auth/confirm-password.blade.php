<x-guest-layout title="Confirm password">
    <h1 class="text-2xl font-semibold tracking-[-0.02em]">Confirm your password</h1>
    <p class="mt-1 text-[0.9375rem] text-slate-500">This is a secure area. Enter your password to continue.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-5">
        @csrf

        <x-form.input name="password" label="Password" type="password" required autofocus autocomplete="current-password" />

        <x-button type="submit" class="w-full">Confirm</x-button>
    </form>
</x-guest-layout>
