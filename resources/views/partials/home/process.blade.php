<section class="bg-white py-16 md:py-24" aria-labelledby="installation-title">
    <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-10">
        <div class="lg:col-span-5">
            <div class="lg:sticky lg:top-28" data-reveal>
                <h2 id="installation-title" class="text-section-title max-w-[18ch]">We don't just sell the hardware.</h2>
                <div class="mt-6 max-w-[52ch] space-y-4">
                    <p>Most equipment vendors stop at the invoice. We start with a site survey, design the system around your building, and procure genuine equipment from our vendor partners.</p>
                    <p>Our engineers then install, test and commission it, train your team at handover, and stay on to maintain it. One contract, one team accountable from the first measurement to the last service visit.</p>
                </div>

                <div class="mt-8 hidden overflow-hidden rounded-lg border border-slate-200 sm:block">
                    <picture>
                        <source type="image/webp" srcset="{{ asset('images/projects/data-voice-cabinet-rack-1.webp') }}">
                        <img src="{{ asset('images/projects/data-voice-cabinet-rack-1.jpg') }}" alt="" width="800" height="450" loading="lazy" decoding="async" class="aspect-[16/8] w-full object-cover">
                    </picture>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <x-button :href="route('about')" variant="secondary">How we work</x-button>
                    <x-button :href="route('quote.create')" variant="ghost">Book a site survey</x-button>
                </div>
            </div>
        </div>

        <ol x-data="processSteps" class="lg:col-span-7">
            @foreach ([
                ['Discovery and design', 'Site surveys, layout mapping and network topology, so the design fits the building and how you use it.'],
                ['Procurement', 'Genuine equipment from our vendor partners, with full manufacturer warranty.'],
                ['Deployment', 'Cabinets, fiber backbones, cameras and access points installed by certified engineers.'],
                ['Testing and commissioning', 'Signal validation, load testing, call-routing checks and failover tests before sign-off.'],
                ['Handover and training', 'Administrator training, documentation and onboarding to your support agreement.'],
            ] as [$phase, $description])
                <li
                    data-step
                    data-reached="false"
                    :data-reached="(active >= {{ $loop->index }}).toString()"
                    class="group relative grid grid-cols-[3.5rem_1fr] gap-4 border-t border-slate-200 py-6 last:border-b sm:grid-cols-[5rem_1fr] md:py-7"
                >
                    {{-- Progress rule: fills along the top border as the reader reaches each phase --}}
                    <span class="absolute inset-x-0 -top-px h-0.5 origin-left scale-x-0 bg-brand-600 transition-transform duration-700 ease-out group-data-[reached=true]:scale-x-100" aria-hidden="true"></span>

                    <span class="font-display text-3xl font-semibold tracking-[-0.02em] text-slate-300 tabular-nums transition-colors duration-500 group-hover:text-brand-600 group-data-[reached=true]:text-brand-600 sm:text-4xl" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div>
                        <h3 class="text-card-title"><span class="sr-only">Phase {{ $loop->iteration }}: </span>{{ $phase }}</h3>
                        <p class="mt-2 max-w-[52ch] text-slate-600">{{ $description }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
