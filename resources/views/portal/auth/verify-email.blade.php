<x-guest-layout title="Verify your email">
    <h1 class="text-2xl font-semibold tracking-[-0.02em]">Verify your email address</h1>
    <p class="mt-1 text-[0.9375rem] text-slate-500">Open the link we emailed you to finish setting up your account. If it has not arrived, we can send another.</p>

    @if (session('status') === 'verification-link-sent')
        <x-alert class="mt-6">A new verification link has been sent to your email address.</x-alert>
    @endif

    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button type="submit">Resend verification email</x-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit" variant="ghost">Log out</x-button>
        </form>
    </div>
</x-guest-layout>
