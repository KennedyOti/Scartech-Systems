<x-layouts.app
    seo-title="Our services"
    seo-description="Scartech Systems supplies, installs and maintains IT, CCTV, structured cabling and VoIP, PA, fire alarm, electric fence, POS, access control and fiber systems in Kenya."
>
    <x-page-header
        title="Our services"
        lead="Supply, installation and maintenance across telecommunications, IT and electronic security."
        :breadcrumbs="[['label' => 'Services', 'url' => null]]"
    />

    <section class="bg-white py-16 md:py-24" aria-label="All services">
        <div class="container-site">
            <div class="grid gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50 py-12 md:py-16" aria-labelledby="engagement-title">
        <div class="container-site grid items-center gap-8 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <h2 id="engagement-title" class="text-section-title max-w-[30ch]">Every engagement includes a site survey, documented design, certified installation, testing and a maintenance plan.</h2>
            </div>
            <ul class="grid grid-cols-2 gap-x-6 gap-y-3 text-[0.9375rem] font-medium text-slate-900 lg:col-span-4">
                @foreach (['Site survey', 'Documented design', 'Certified installation', 'Testing', 'Handover training', 'Maintenance plan'] as $step)
                    <li class="flex items-center gap-2">
                        <x-lucide-check class="size-4 shrink-0 text-brand-600" aria-hidden="true" />
                        {{ $step }}
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <x-cta-band />
</x-layouts.app>
