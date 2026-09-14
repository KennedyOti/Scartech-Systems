<section class="bg-white py-16 md:py-24" aria-labelledby="partners-title">
    <div class="container-site" data-reveal>
        <x-section-heading id="partners-title" title="Technology partners" lead="We supply and install equipment from established manufacturers." />
        <x-partner-wall :partners="$company['partners']" class="mt-10" />
    </div>
</section>

{{-- Clients (renders only when confirmed clients are featured — see ClientSeeder) --}}
@if ($clients->isNotEmpty())
    <section class="bg-white py-16 md:py-24" aria-labelledby="clients-title">
        <div class="container-site" data-reveal>
            <x-section-heading id="clients-title" title="Clients" lead="Our work includes direct contracts and sub-contracts from IT firms that rely on our engineering." />
            <x-client-wall :clients="$clients" class="mt-10" />
        </div>
    </section>
@endif
