<x-guest-layout title="Sign in">
    <h1 class="text-2xl font-semibold tracking-[-0.02em]">Sign in to the portal</h1>
    <p class="mt-1 text-[0.9375rem] text-slate-500">Manage portfolio projects and products on the Scartech website.</p>

    @if (session('status'))
        <x-alert class="mt-6">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <x-form.input name="email" label="Email address" type="email" required autofocus autocomplete="username" />

        <div>
            <x-form.input name="password" label="Password" type="password" required autocomplete="current-password" />
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="mt-2 inline-block text-sm font-medium text-brand-600 hover:text-brand-700">
                    Forgot your password?
                </a>
            @endif
        </div>

        <x-form.checkbox name="remember" label="Keep me signed in" />

        <x-button type="submit" class="w-full">Sign in</x-button>
    </form>
</x-guest-layout>
