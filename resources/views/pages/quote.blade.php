<x-layouts.app
    seo-title="Request a quote"
    seo-description="Request a quote or site survey from Scartech Systems for CCTV, access control, structured cabling, VoIP, fiber, fire alarm, PA, POS or IT systems in Kenya."
>
    <div class="border-b border-slate-200 bg-slate-25">
        <div class="mx-auto max-w-[720px] px-5 pt-10 pb-10 sm:px-8 md:pt-14">
            <x-breadcrumbs :items="[['label' => 'Request a quote', 'url' => null]]" />
            <h1 class="text-page-title mt-6">Request a quote</h1>
            <p class="text-lead mt-4 text-slate-600">Tell us about the site and what you need. An engineer will review it and contact you within one working day, usually to arrange a site survey.</p>
        </div>
    </div>

    <section class="mx-auto max-w-[720px] px-5 py-12 sm:px-8 md:py-16" aria-label="Quote request form">
        @if (session('status'))
            <x-alert class="mb-8">{{ session('status') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error" class="mb-8">Check the highlighted fields and try again.</x-alert>
        @endif

        <form method="POST" action="{{ route('quote.store') }}" x-data="enquiryForm" @submit="submit" class="space-y-10" novalidate>
            @csrf
            <x-form.honeypot />
            @if ($selectedProduct || old('product'))
                <input type="hidden" name="product" value="{{ old('product', $selectedProduct) }}">
            @endif

            <fieldset class="space-y-5">
                <legend class="text-card-title">Your details</legend>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="name" label="Your name" autocomplete="name" required />
                    <x-form.input name="company" label="Company or organisation" autocomplete="organization" optional />
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="email" type="email" label="Email" autocomplete="email" required />
                    <x-form.input name="phone" type="tel" label="Phone" autocomplete="tel" required />
                </div>
            </fieldset>

            <fieldset class="space-y-5 border-t border-slate-200 pt-8">
                <legend class="text-card-title float-left w-full pb-5">The project</legend>

                @if ($selectedProduct || old('product'))
                    <p class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-25 px-4 py-3 text-[0.9375rem]">
                        <x-lucide-package class="size-4 text-brand-600" aria-hidden="true" />
                        <span>Enquiring about: <strong class="text-slate-900">{{ old('product', $selectedProduct) }}</strong></span>
                    </p>
                @endif

                <x-form.select name="service_id" label="Service" :options="$services->pluck('name', 'id')->all()" :value="$selectedServiceId" placeholder="Not sure yet" optional />
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-form.input name="location" label="Location or town" autocomplete="address-level2" optional />
                    <x-form.select name="site_type" label="Site type" :options="\App\Models\QuoteRequest::SITE_TYPES" optional />
                </div>
                <x-form.select name="timeline" label="Estimated timeline" :options="\App\Models\QuoteRequest::TIMELINES" optional />
                <x-form.checkbox name="needs_site_survey" label="I would like a site survey" hint="An engineer visits to measure and scope the work before we quote." :checked="true" />
                <x-form.textarea name="details" label="Project details" hint="For example: number of floors or buildings, how many cameras, doors or users, and anything already installed." rows="7" required />
            </fieldset>

            <div class="flex flex-col gap-4 border-t border-slate-200 pt-8 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">We use your details only to respond to this request.</p>
                <x-button type="submit" size="lg" ::disabled="sending" class="w-full sm:w-auto">
                    <span x-text="sending ? 'Sending…' : 'Send request'">Send request</span>
                </x-button>
            </div>
        </form>
    </section>
</x-layouts.app>
