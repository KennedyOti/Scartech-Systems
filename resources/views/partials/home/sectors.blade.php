<section class="bg-slate-50 py-16 md:py-24" aria-labelledby="sectors-title">
    <div class="container-site">
        <x-section-heading id="sectors-title" title="Sectors we work in" lead="Systems designed around how each kind of building is used, secured and maintained." data-reveal />

        <ul class="mt-10 grid border-t border-l border-slate-200 bg-white sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @foreach ([
                ['graduation-cap', 'Educational institutions', 'Campus networks, CCTV, PA and bell systems, access control for hostels and labs.'],
                ['building-2', 'Corporate facilities and business parks', 'Structured cabling, IP telephony, boardroom AV and building security.'],
                ['landmark', 'Financial and banking', 'Branch surveillance, biometric access to strongrooms and server rooms, secure networks.'],
                ['hotel', 'Hospitality and retail', 'Guest Wi-Fi, POS systems, CCTV across floors and background music.'],
            ] as [$icon, $sector, $description])
                <li class="group relative border-r border-b border-slate-200 p-6 transition-colors duration-[120ms] hover:bg-brand-50/40 md:p-7">
                    <span class="absolute inset-x-0 -top-px h-0.5 origin-left scale-x-0 bg-brand-600 transition-transform duration-300 ease-out group-hover:scale-x-100" aria-hidden="true"></span>
                    <span class="flex size-10 items-center justify-center rounded-md bg-brand-50 text-brand-600 transition-colors duration-[120ms] group-hover:bg-brand-600 group-hover:text-white">
                        @svg('lucide-'.$icon, 'size-5', ['aria-hidden' => 'true'])
                    </span>
                    <h3 class="mt-5 text-lg leading-snug font-semibold">{{ $sector }}</h3>
                    <p class="mt-2 text-[0.9375rem] text-slate-600">{{ $description }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
