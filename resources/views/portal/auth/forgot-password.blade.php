<x-guest-layout title="Reset password">
    <h1 class="text-2xl font-semibold tracking-[-0.02em]">Reset your password</h1>
    <p class="mt-1 text-[0.9375rem] text-slate-500">Enter your email address and we will send you a link to choose a new password.</p>

    @if (session('status'))
        <x-alert class="mt-6">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf

        <x-form.input name="email" label="Email address" type="email" required autofocus autocomplete="username" />

        <x-button type="submit" class="w-full">Email reset link</x-button>
    </form>

    <a href="{{ route('login') }}" class="mt-5 inline-block text-sm font-medium text-brand-600 hover:text-brand-700">Back to sign in</a>
</x-guest-layout>
