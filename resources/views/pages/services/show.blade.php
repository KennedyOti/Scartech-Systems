@php
    $primaryPhone = $company['offices'][0]['phones'][0];
@endphp

<x-layouts.app
    :seo-title="$service->meta_title ?? $service->name.' in Kenya'"
    :seo-description="$service->meta_description ?? $service->summary"
    :seo-image="$service->og_image ?? $service->hero_image"
>
    <x-slot:schema>
        <x-schema.service :service="$service" />
    </x-slot:schema>

    <div class="container-site grid gap-12 pt-10 pb-16 md:pt-14 md:pb-24 lg:grid-cols-12 lg:gap-10">
        <article class="min-w-0 lg:col-span-8">
            <x-breadcrumbs :items="[
                ['label' => 'Services', 'url' => route('services.index')],
                ['label' => $service->name, 'url' => null],
            ]" />

            <div class="mt-8 flex items-center gap-4">
                <span class="flex size-12 shrink-0 items-center justify-center rounded-md bg-brand-50 text-brand-600">
                    @svg('lucide-'.$service->icon, 'size-6', ['aria-hidden' => 'true'])
                </span>
                <h1 class="text-page-title">{{ $service->name }}</h1>
            </div>
            <p class="mt-5 font-display text-xl font-semibold tracking-[-0.01em] text-slate-900">{{ $service->tagline }}</p>
            <p class="text-lead mt-4 max-w-[68ch] text-slate-600">{{ $service->summary }}</p>

            @if ($service->hero_image)
                <div class="mt-10 aspect-[16/9] overflow-hidden rounded-lg bg-slate-100">
                    <img
                        src="{{ asset($service->hero_image) }}"
                        alt="{{ $service->name }} work by Scartech Systems: {{ Str::lcfirst($service->tagline) }}"
                        width="1600"
                        height="900"
                        fetchpriority="high"
                        class="size-full object-cover"
                    >
                </div>
            @endif

            <div class="rich-text mt-10">
                {!! $service->body !!}
            </div>

            @if (! empty($service->capabilities))
                <section class="mt-14" aria-labelledby="deliver-title">
                    <h2 id="deliver-title" class="text-section-title">What we deliver</h2>
                    <dl class="mt-6 border-b border-slate-200">
                        @foreach ($service->capabilities as $capability)
                            <div class="grid gap-1 border-t border-slate-200 py-5 md:grid-cols-[16rem_1fr] md:gap-8">
                                <dt class="font-semibold text-slate-900">{{ $capability['title'] }}</dt>
                                <dd class="text-slate-600">{{ $capability['description'] }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    @if (! empty($service->deliverables))
                        <h3 class="text-card-title mt-10">At handover you receive</h3>
                        <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                            @foreach ($service->deliverables as $deliverable)
                                <li class="flex gap-2.5 text-slate-700">
                                    <x-lucide-check class="mt-1 size-4 shrink-0 text-brand-600" aria-hidden="true" />
                                    {{ $deliverable }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endif

            @if (! empty($service->applications))
                <section class="mt-14" aria-labelledby="applications-title">
                    <h2 id="applications-title" class="text-section-title">Where it's used</h2>
                    <ul class="mt-5 flex flex-wrap gap-2">
                        @foreach ($service->applications as $application)
                            <li class="rounded-sm border border-slate-200 px-3 py-1.5 text-[0.9375rem] text-slate-700">{{ $application }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if (! empty($service->brands))
                <section class="mt-14" aria-labelledby="brands-title">
                    <h2 id="brands-title" class="text-section-title">Brands we work with</h2>
                    <ul class="mt-5 flex flex-wrap gap-2">
                        @foreach ($service->brands as $brand)
                            <li class="rounded-sm border border-slate-300 bg-slate-25 px-3 py-1.5 text-[0.9375rem] font-semibold text-slate-900">{{ $brand }}</li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($relatedProjects->isNotEmpty())
                <section class="mt-16" aria-labelledby="related-projects-title">
                    <h2 id="related-projects-title" class="text-section-title">Related projects</h2>
                    <div class="mt-8 grid gap-x-8 gap-y-10 sm:grid-cols-2">
                        @foreach ($relatedProjects as $project)
                            <x-project-card :project="$project" />
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($relatedProducts->isNotEmpty())
                <section class="mt-16" aria-labelledby="related-products-title">
                    <h2 id="related-products-title" class="text-section-title">Related products</h2>
                    <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-4">
                        @foreach ($relatedProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="mt-16 flex flex-col gap-6 rounded-lg border border-slate-200 bg-slate-25 p-6 sm:flex-row sm:items-center sm:justify-between md:p-8" aria-labelledby="survey-title">
                <div>
                    <h2 id="survey-title" class="text-card-title">Request a site survey for {{ $service->name }}</h2>
                    <p class="mt-2 text-[0.9375rem] text-slate-600">An engineer visits, measures and scopes the work before we quote.</p>
                </div>
                <x-button :href="route('quote.create', ['service' => $service->slug])" class="shrink-0">Request a site survey</x-button>
            </section>
        </article>

        <aside class="lg:col-span-4" aria-label="Contact and other services">
            <div class="space-y-8 lg:sticky lg:top-28">
                <div class="rounded-lg border border-slate-200 p-6">
                    <h2 class="text-card-title">Talk to an engineer</h2>
                    <ul class="mt-5 space-y-2">
                        @foreach ($company['offices'][0]['phones'] as $phone)
                            <li>
                                <a href="{{ Str::telHref($phone) }}" class="inline-flex min-h-10 items-center gap-2.5 text-[0.9375rem] font-medium whitespace-nowrap text-slate-900 hover:text-brand-600">
                                    <x-lucide-phone class="size-4 text-brand-600" aria-hidden="true" />{{ $phone }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="mailto:{{ $company['email'] }}" class="inline-flex min-h-10 items-center gap-2.5 text-[0.9375rem] font-medium text-slate-900 hover:text-brand-600">
                                <x-lucide-mail class="size-4 text-brand-600" aria-hidden="true" />{{ $company['email'] }}
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/{{ $company['whatsapp'] }}?text={{ rawurlencode('Hello Scartech Systems, I would like to enquire about '.$service->name) }}" target="_blank" rel="noopener" class="inline-flex min-h-10 items-center gap-2.5 text-[0.9375rem] font-medium text-slate-900 hover:text-brand-600">
                                <x-lucide-message-circle class="size-4 text-brand-600" aria-hidden="true" />WhatsApp us
                            </a>
                        </li>
                    </ul>
                    <x-button :href="route('quote.create', ['service' => $service->slug])" class="mt-6 w-full">Request a quote</x-button>
                </div>

                <nav aria-labelledby="other-services-title">
                    <h2 id="other-services-title" class="text-meta text-slate-500">Other services</h2>
                    <ul class="mt-3 border-b border-slate-200">
                        @foreach ($otherServices as $otherService)
                            <li>
                                <a href="{{ route('services.show', $otherService) }}" class="group flex min-h-12 items-center gap-3 border-t border-slate-200 py-2.5 text-[0.9375rem] font-medium text-slate-900 hover:text-brand-600">
                                    @svg('lucide-'.$otherService->icon, 'size-4 shrink-0 text-slate-400 group-hover:text-brand-600', ['aria-hidden' => 'true'])
                                    {{ $otherService->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </aside>
    </div>

    <x-cta-band />
</x-layouts.app>
