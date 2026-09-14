<x-layouts.app seo-title="Page not found" :noindex="true">
    <section class="bg-white py-20 md:py-32">
        <div class="container-site text-center">
            <x-waveform variant="mark" class="mx-auto h-12 w-auto" />
            <h1 class="text-page-title mx-auto mt-8 max-w-[20ch]">We couldn't find that page.</h1>
            <p class="text-lead mx-auto mt-4 max-w-[48ch] text-slate-600">It may have moved. Try our services, products or portfolio.</p>
            <ul class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <li><x-button :href="route('services.index')">Our services</x-button></li>
                <li><x-button :href="route('products.index')" variant="secondary">Products</x-button></li>
                <li><x-button :href="route('portfolio.index')" variant="secondary">Portfolio</x-button></li>
                <li><x-button :href="route('contact.index')" variant="ghost">Contact us</x-button></li>
            </ul>
        </div>
    </section>
</x-layouts.app>
