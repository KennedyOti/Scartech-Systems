@php
    $subjects = $services->pluck('name')->merge(['General enquiry', 'Support'])->all();
@endphp

<x-layouts.app
    seo-title="Contact us"
    seo-description="Contact Scartech Systems in Nairobi, Kampala or Kigali. Call +254 714 801 680, email info@scartech.co.ke or send us a message. We reply within one working day."
>
    <x-page-header
        title="Contact us"
        lead="Tell us what you need. We reply within one working day."
        :breadcrumbs="[['label' => 'Contact us', 'url' => null]]"
    />

    <section class="bg-white py-16 md:py-20">
        <div class="container-site grid gap-14 lg:grid-cols-12 lg:gap-12">
            <div class="lg:col-span-6">
                <h2 class="text-section-title">Send a message</h2>
                <p class="mt-3 text-slate-600">
                    For a priced proposal, use the
                    <a href="{{ route('quote.create') }}" class="font-semibold text-brand-600 underline underline-offset-4 hover:text-brand-700">quote request form</a>
                    instead.
                </p>

                @if (session('status'))
                    <x-alert class="mt-6">{{ session('status') }}</x-alert>
                @endif

                @if ($errors->any())
                    <x-alert type="error" class="mt-6">Check the highlighted fields and try again.</x-alert>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" x-data="enquiryForm" @submit="submit" class="mt-8 space-y-5" novalidate>
                    @csrf
                    <x-form.honeypot />

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.input name="name" label="Your name" autocomplete="name" required />
                        <x-form.input name="company" label="Company" autocomplete="organization" optional />
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-form.input name="email" type="email" label="Email" autocomplete="email" required />
                        <x-form.input name="phone" type="tel" label="Phone" autocomplete="tel" required />
                    </div>
                    <x-form.select name="subject" label="What is it about?" :options="$subjects" required />
                    <x-form.textarea name="message" label="Message" hint="Include the site location and the systems involved if you can." required />

                    <x-button type="submit" size="lg" ::disabled="sending" class="w-full sm:w-auto">
                        <span x-text="sending ? 'Sending…' : 'Send message'">Send message</span>
                    </x-button>
                </form>
            </div>

            <div class="lg:col-span-5 lg:col-start-8">
                <h2 class="text-section-title">Reach us directly</h2>

                @php $hq = $company['offices'][0]; @endphp
                <div class="mt-6 rounded-lg border border-slate-200 p-6">
                    <h3 class="text-card-title">{{ $hq['city'] }} <span class="font-body text-base font-normal text-slate-500">{{ $hq['label'] }}</span></h3>
                    <ul class="mt-4 space-y-1">
                        @foreach ($hq['phones'] as $phone)
                            <li>
                                <a href="{{ Str::telHref($phone) }}" class="inline-flex min-h-11 items-center gap-3 font-medium whitespace-nowrap text-slate-900 hover:text-brand-600">
                                    <x-lucide-phone class="size-4 text-brand-600" aria-hidden="true" />{{ $phone }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="mailto:{{ $company['email'] }}" class="inline-flex min-h-11 items-center gap-3 font-medium text-slate-900 hover:text-brand-600">
                                <x-lucide-mail class="size-4 text-brand-600" aria-hidden="true" />{{ $company['email'] }}
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/{{ $company['whatsapp'] }}" target="_blank" rel="noopener" class="inline-flex min-h-11 items-center gap-3 font-medium text-slate-900 hover:text-brand-600">
                                <x-lucide-message-circle class="size-4 text-brand-600" aria-hidden="true" />WhatsApp {{ $hq['phones'][0] }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach (array_slice($company['offices'], 1) as $office)
                        <div class="rounded-lg border border-slate-200 p-5">
                            <h3 class="font-display text-lg font-semibold">{{ $office['city'] }}</h3>
                            <p class="text-sm text-slate-500">{{ $office['country'] }}</p>
                            @foreach ($office['phones'] as $phone)
                                <a href="{{ Str::telHref($phone) }}" class="mt-2 inline-flex min-h-11 items-center gap-2 font-medium whitespace-nowrap text-slate-900 hover:text-brand-600">
                                    <x-lucide-phone class="size-4 text-brand-600" aria-hidden="true" />{{ $phone }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 border-t border-slate-200 pt-6">
                    <h3 class="flex items-center gap-2 text-lg font-semibold"><x-lucide-clock class="size-5 text-brand-600" aria-hidden="true" /> Business hours</h3>
                    <dl class="mt-4 grid grid-cols-[10rem_1fr] gap-y-2 text-[0.9375rem]">
                        <dt class="text-slate-500">Monday to Friday</dt><dd class="font-medium text-slate-900 tabular-nums">{{ $company['hours']['weekday'] }}</dd>
                        <dt class="text-slate-500">Saturday</dt><dd class="font-medium text-slate-900 tabular-nums">{{ $company['hours']['saturday'] }}</dd>
                        <dt class="text-slate-500">Sunday</dt><dd class="font-medium text-slate-900">{{ $company['hours']['sunday'] }}</dd>
                    </dl>
                    <p class="mt-5 flex gap-2.5 rounded-md bg-brand-50 px-4 py-3 text-[0.9375rem] text-slate-800">
                        <x-lucide-headset class="mt-0.5 size-5 shrink-0 text-brand-600" aria-hidden="true" />
                        Support is available {{ $company['hours']['support'] }}.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-slate-200 bg-slate-25 py-16 md:py-20" aria-labelledby="offices-title">
        <div class="container-site">
            <x-section-heading id="offices-title" title="Our offices" />
            <x-offices-table class="mt-8" />
        </div>
    </section>
</x-layouts.app>
