<x-app-layout title="Products">
    <x-portal::page-header title="Products" description="Equipment listed in the website’s product catalogue. Only live products are visible to visitors.">
        <x-slot:actions>
            <x-button :href="route('portal.products.create')" icon="plus">Add product</x-button>
        </x-slot:actions>
    </x-portal::page-header>

    <form method="GET" action="{{ route('portal.products.index') }}" role="search" class="mb-5 flex flex-wrap gap-2">
        <label for="search" class="sr-only">Search products</label>
        <div class="relative min-w-60 flex-1 sm:max-w-sm">
            <x-lucide-search class="pointer-events-none absolute top-1/2 left-3 size-[1.125rem] -translate-y-1/2 text-slate-400" aria-hidden="true" />
            <input type="search" id="search" name="search" value="{{ $search }}" placeholder="Search by name, brand or model" class="block min-h-11 w-full rounded-md border border-slate-300 bg-white py-2 pr-3 pl-10 text-[0.9375rem] text-slate-900 placeholder:text-slate-400 transition-colors duration-[120ms] hover:border-slate-400 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600">
        </div>
        <label for="category" class="sr-only">Category</label>
        <select id="category" name="category" onchange="this.form.submit()" class="min-h-11 rounded-md border border-slate-300 bg-white py-2 pr-9 pl-3 text-[0.9375rem] text-slate-900 transition-colors duration-[120ms] hover:border-slate-400 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" @selected($activeCategory?->is($category))>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-button type="submit" variant="secondary">Search</x-button>
    </form>

    @if ($products->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
            <x-lucide-package class="mx-auto size-8 text-slate-400" aria-hidden="true" />
            @if ($search !== '' || $activeCategory)
                <p class="mt-3 font-medium text-slate-900">No products match these filters.</p>
                <a href="{{ route('portal.products.index') }}" class="mt-2 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">Clear filters</a>
            @else
                <p class="mt-3 font-medium text-slate-900">No products yet.</p>
                <p class="mt-1 text-sm text-slate-500">Products you add and mark as live appear on the website’s Products page.</p>
                <x-button :href="route('portal.products.create')" icon="plus" class="mt-5">Add product</x-button>
            @endif
        </div>
    @else
        <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
            <table class="w-full min-w-[48rem] text-left text-[0.9375rem]">
                <thead class="border-b border-slate-200 bg-slate-50 text-meta text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3 font-medium">Product</th>
                        <th scope="col" class="px-5 py-3 font-medium">Category</th>
                        <th scope="col" class="px-5 py-3 font-medium">Status</th>
                        <th scope="col" class="px-5 py-3 font-medium">Order</th>
                        <th scope="col" class="px-5 py-3 text-right font-medium"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($products as $product)
                        <tr class="transition-colors duration-[120ms] hover:bg-slate-25">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $product->image_url }}" alt="" loading="lazy" class="size-12 shrink-0 rounded-md border border-slate-200 bg-white object-contain">
                                    <div class="min-w-0">
                                        <a href="{{ route('portal.products.show', $product) }}" class="font-medium text-slate-900 hover:text-brand-600">{{ $product->name }}</a>
                                        <p class="mt-0.5 text-sm text-slate-500">{{ collect([$product->brand, $product->model_number])->filter()->implode(' · ') ?: '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-700">{{ $product->category?->name }}</td>
                            <td class="px-5 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @if ($product->is_active)
                                        <x-portal::badge tone="success">Live</x-portal::badge>
                                    @else
                                        <x-portal::badge>Hidden</x-portal::badge>
                                    @endif
                                    @if ($product->is_featured)
                                        <x-portal::badge tone="brand"><x-lucide-star class="size-3" aria-hidden="true" /> Featured</x-portal::badge>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-700 tabular-nums">{{ $product->sort_order }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('portal.products.show', $product) }}" class="inline-flex size-9 items-center justify-center rounded-md text-slate-500 transition-colors duration-[120ms] hover:bg-slate-100 hover:text-slate-900" title="View">
                                        <x-lucide-eye class="size-[1.125rem]" aria-hidden="true" /><span class="sr-only">View {{ $product->name }}</span>
                                    </a>
                                    <a href="{{ route('portal.products.edit', $product) }}" class="inline-flex size-9 items-center justify-center rounded-md text-slate-500 transition-colors duration-[120ms] hover:bg-slate-100 hover:text-slate-900" title="Edit">
                                        <x-lucide-pencil class="size-[1.125rem]" aria-hidden="true" /><span class="sr-only">Edit {{ $product->name }}</span>
                                    </a>
                                    <x-portal::delete-button
                                        :action="route('portal.products.destroy', $product)"
                                        :confirm="'Delete “'.$product->name.'”? Its images and datasheet will be removed too.'"
                                        :label="'Delete '.$product->name"
                                        icon-only
                                    />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    @endif
</x-app-layout>
