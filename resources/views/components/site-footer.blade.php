<footer class="bg-brand-900 text-slate-300">
    <div class="container-site grid gap-12 py-16 md:grid-cols-2 md:py-20 lg:grid-cols-12 lg:gap-10">
        <div class="lg:col-span-4">
            <a href="{{ route('home') }}" aria-label="Scartech Systems — home" class="inline-block rounded-md">
                <img src="{{ asset('images/brand/scartech-logo-white.png') }}" alt="" width="652" height="180" loading="lazy" class="h-11 w-auto">
            </a>
            <p class="mt-6 max-w-[40ch] text-[0.9375rem] leading-relaxed text-slate-300">
                {{ $company['positioning'] }}
            </p>
            <ul class="mt-6 flex flex-wrap items-center text-sm text-slate-200" aria-label="Company values">
                @foreach ($company['values'] as $value)
                    <li @class(['px-3', 'pl-0' => $loop->first, 'border-l border-white/20' => ! $loop->first])>{{ $value }}</li>
                @endforeach
            </ul>
        </div>

        <nav aria-labelledby="footer-services" class="lg:col-span-3">
            <h2 id="footer-services" class="font-display text-base font-semibold text-white">Services</h2>
            <ul class="mt-5 space-y-1">
                @foreach ($navServices as $navService)
                    <li>
                        <a href="{{ route('services.show', $navService) }}" class="inline-flex min-h-9 items-center rounded-sm text-[0.9375rem] text-slate-300 transition-colors duration-[120ms] hover:text-white">{{ $navService->name }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <nav aria-labelledby="footer-company" class="lg:col-span-2">
            <h2 id="footer-company" class="font-display text-base font-semibold text-white">Company</h2>
            <ul class="mt-5 space-y-1">
                @foreach ([
                    'About us' => route('about'),
                    'Portfolio' => route('portfolio.index'),
                    'Products' => route('products.index'),
                    'Contact us' => route('contact.index'),
                    'Request a quote' => route('quote.create'),
                ] as $label => $url)
                    <li>
                        <a href="{{ $url }}" class="inline-flex min-h-9 items-center rounded-sm text-[0.9375rem] text-slate-300 transition-colors duration-[120ms] hover:text-white">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="lg:col-span-3">
            <h2 class="font-display text-base font-semibold text-white">Offices</h2>
            <ul class="mt-5 space-y-5">
                @foreach ($company['offices'] as $office)
                    <li>
                        <p class="text-[0.9375rem] font-semibold text-white">{{ $office['city'] }}, {{ $office['country'] }}</p>
                        <ul class="mt-1">
                            @foreach ($office['phones'] as $phone)
                                <li>
                                    <a href="{{ Str::telHref($phone) }}" class="inline-flex min-h-8 items-center rounded-sm text-[0.9375rem] whitespace-nowrap text-slate-300 hover:text-white">{{ $phone }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <p class="mt-5 text-sm text-slate-300">Opening soon: {{ implode(', ', $company['expansion']) }}</p>
            <a href="mailto:{{ $company['email'] }}" class="mt-4 inline-flex min-h-9 items-center gap-2 rounded-sm text-[0.9375rem] font-medium text-white hover:text-brand-200">
                <x-lucide-mail class="size-4" aria-hidden="true" />
                {{ $company['email'] }}
            </a>
        </div>
    </div>

    <div class="border-t border-white/12">
        <div class="container-site flex flex-col-reverse gap-4 py-6 pb-24 sm:flex-row sm:items-center sm:justify-between sm:pr-24 sm:pb-6">
            <p class="text-sm text-slate-300">&copy; {{ date('Y') }} {{ $company['legal_name'] }}. All rights reserved.</p>
            <x-waveform variant="mark" tone="dark" class="h-6 w-auto opacity-50" />
        </div>
    </div>
</footer>
