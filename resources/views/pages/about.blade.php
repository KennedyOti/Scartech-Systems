<x-layouts.app
    seo-title="About us"
    seo-description="Scartech Systems Limited provides end-to-end IT, telecommunications and electronic security solutions from Nairobi, with offices in Kampala and Kigali."
>
    <x-page-header
        title="About Scartech Systems"
        lead="We deliver end-to-end IT, telecommunications and electronic security solutions across Kenya and East Africa. Through partnerships with global hardware and software manufacturers, we serve clients in business, education and finance."
        :breadcrumbs="[['label' => 'About us', 'url' => null]]"
    />

    {{-- Who we are --}}
    <section class="bg-white py-16 md:py-24" aria-labelledby="who-title">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-10">
            <div class="lg:col-span-7">
                <h2 id="who-title" class="text-section-title">Who we are</h2>
                <div class="mt-6 max-w-[68ch] space-y-5">
                    <p class="text-lead text-slate-700">{{ $company['positioning'] }}</p>

                    <h3 class="text-card-title pt-4">Our expertise</h3>
                    <p>Our engineers work across ten disciplines: IT infrastructure, CCTV surveillance, structured cabling and IP telephony, sound and PA, event technical production, fire detection, electric fencing, point of sale, access control and fiber optics. Because these systems share cabling, power and networks, having one team responsible for all of them avoids the gaps that appear when several contractors work on the same building.</p>

                    <h3 class="text-card-title pt-4">Our operational scope</h3>
                    <p>From our headquarters in Nairobi and regional offices in Kampala and Kigali, we handle every stage of a project: site survey, design, procurement, installation, testing and commissioning, handover training and ongoing maintenance. We work on direct contracts for end clients and as a sub-contractor for IT firms that rely on our engineering.</p>

                    <h3 class="text-card-title pt-4">Why clients choose us</h3>
                    <ul class="space-y-2.5">
                        @foreach ([
                            'We supply and install, so the equipment we recommend is the equipment we stand behind.',
                            'Genuine hardware from vendor partners, with manufacturer warranty.',
                            'Documented, tested installations: test reports, as-built records and training at handover.',
                            'Maintenance and support after go-live, including 24/7 support for clients on an SLA.',
                        ] as $reason)
                            <li class="flex gap-2.5">
                                <x-lucide-check class="mt-1.5 size-4 shrink-0 text-brand-600" aria-hidden="true" />
                                <span>{{ $reason }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="space-y-4 lg:sticky lg:top-28">
                    <div class="aspect-[4/5] overflow-hidden rounded-lg bg-slate-100">
                        <img src="{{ asset('images/projects/high-density-patching.jpg') }}" alt="Network racks with high-density patch panels and colour-coded cabling, with an engineer walking the aisle" width="1023" height="679" loading="lazy" class="size-full object-cover">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="aspect-square overflow-hidden rounded-lg bg-slate-100">
                            <img src="{{ asset('images/projects/cctv-control-room-video-wall.jpg') }}" alt="CCTV monitor showing a multi-camera view of a restaurant installation" width="1600" height="1200" loading="lazy" class="size-full object-cover">
                        </div>
                        <div class="aspect-square overflow-hidden rounded-lg bg-slate-100">
                            <img src="{{ asset('images/hero/boardroom-av.jpg') }}" alt="Boardroom fitted with a display, conference camera and conference phone" width="1600" height="1067" loading="lazy" class="size-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Focus, vision, purpose --}}
    <section class="bg-slate-50 py-16 md:py-24" aria-labelledby="direction-title">
        <div class="container-site">
            <h2 id="direction-title" class="sr-only">Our focus, vision and purpose</h2>
            <div class="grid gap-10 md:grid-cols-3 md:gap-8">
                @foreach ([
                    'Our focus' => [
                        'Advisory, installation and maintenance of telecom and security systems',
                        'Solutions that fit the client\'s building, budget and operations',
                        'Long-term support relationships, not one-off sales',
                    ],
                    'Our vision' => [
                        'To be a systems integrator East African organisations rely on for the long term',
                        'To grow our regional presence into Tanzania and Burundi',
                        'To set the standard for documented, tested installations',
                    ],
                    'Our purpose' => [
                        'Keep our clients\' people, property and data secure',
                        'Keep their communications and networks running',
                        'Deliver professional, valuable and excellent service every time',
                    ],
                ] as $heading => $points)
                    <div class="border-t-2 border-brand-600 pt-6">
                        <h3 class="text-card-title">{{ $heading }}</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($points as $point)
                                <li class="flex gap-2.5 text-slate-700">
                                    <span class="mt-2.5 h-px w-3 shrink-0 bg-slate-400" aria-hidden="true"></span>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Regional presence --}}
    <section class="bg-white py-16 md:py-24" aria-labelledby="presence-title">
        <div class="container-site grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <x-section-heading id="presence-title" title="Regional presence" lead="Headquartered in Nairobi, with regional offices in Kampala and Kigali." />
            </div>
            <x-offices-table class="lg:col-span-8" />
        </div>
    </section>

    {{-- Team and philosophy --}}
    <section class="bg-slate-25 py-16 md:py-24" aria-labelledby="team-title">
        <div class="container-site grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <h2 id="team-title" class="text-section-title">Our team and philosophy</h2>
            </div>
            <div class="max-w-[68ch] space-y-5 lg:col-span-7">
                <p class="text-lead text-slate-700">Our team combines consultants who understand how organisations operate with field engineers who install and maintain the systems on site.</p>
                <p>We work collaboratively, with our clients' IT and facilities teams and with each other, sharing knowledge across disciplines so that a cabling engineer understands the CCTV system that runs over it, and a security installer understands the network it depends on. That culture is what lets us take responsibility for a whole building's systems, not just one part of it.</p>
            </div>
        </div>
    </section>

    {{-- Partners --}}
    <section class="bg-white py-16 md:py-24" aria-labelledby="partners-title">
        <div class="container-site">
            <x-section-heading id="partners-title" title="Technology partners" lead="We supply and install equipment from established manufacturers." />
            <x-partner-wall :partners="$company['partners']" class="mt-8" />
        </div>
    </section>

    @if ($clients->isNotEmpty())
        <section class="bg-white pb-16 md:pb-24" aria-labelledby="about-clients-title">
            <div class="container-site">
                <x-section-heading id="about-clients-title" title="Clients" />
                <x-client-wall :clients="$clients" class="mt-8" />
            </div>
        </section>
    @endif

    <x-cta-band />
</x-layouts.app>
