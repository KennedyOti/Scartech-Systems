<section class="bg-brand-900 py-16 md:py-24" aria-labelledby="standards-title">
    <div class="container-site">
        <x-section-heading id="standards-title" tone="dark" title="Standards we work to" lead="Documented, tested installations that your auditors, insurers and IT team can rely on." data-reveal />

        <ul class="mt-10 grid border-t border-l border-white/12 md:grid-cols-3" data-reveal>
            @foreach ([
                ['file-check', 'Structured cabling', 'Installed to', 'TIA/EIA-568-C', 'with Fluke-certified test reports for every link.'],
                ['phone', 'Voice systems', 'Compliant with', 'SIP/H.323', 'with QoS tuning so calls stay clear on a shared network.'],
                ['shield-check', 'Data protection', 'Aligned to', 'ISO 27001', 'practices for access, credentials and system configuration.'],
            ] as [$icon, $title, $prefix, $standard, $suffix])
                <li class="border-r border-b border-white/12 p-6 transition-colors duration-[120ms] hover:bg-white/5 md:p-8">
                    @svg('lucide-'.$icon, 'size-6 text-brand-300', ['aria-hidden' => 'true'])
                    <h3 class="mt-5 text-lg font-semibold text-white">{{ $title }}</h3>
                    <p class="mt-2 text-[0.9375rem] text-slate-200">{{ $prefix }} <span class="font-mono text-[0.875rem] text-white">{{ $standard }}</span> {{ $suffix }}</p>
                </li>
            @endforeach
        </ul>

        <p class="mt-10 flex max-w-[68ch] items-start gap-3 text-slate-200">
            <x-lucide-badge-check class="mt-1 size-5 shrink-0 text-brand-300" aria-hidden="true" />
            <span>12-month manufacturer warranty on supplied hardware, and a 90-day installation workmanship guarantee.</span>
        </p>
    </div>
</section>
