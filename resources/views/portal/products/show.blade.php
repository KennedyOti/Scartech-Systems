<x-app-layout :title="$product->name">
    <x-portal::page-header :title="$product->name" :description="$product->summary" :back="route('portal.products.index')" back-label="All products">
        <x-slot:actions>
            @if ($product->is_active)
                <x-button :href="route('products.show', $product)" variant="ghost" icon="external-link" target="_blank" rel="noopener">View on site</x-button>
            @endif
            <x-portal::delete-button :action="route('portal.products.destroy', $product)" :confirm="'Delete “'.$product->name.'”? Its images and datasheet will be removed too.'" />
            <x-button :href="route('portal.products.edit', $product)" icon="pencil">Edit</x-button>
        </x-slot:actions>
    </x-portal::page-header>

    <div class="grid gap-6 lg:grid-cols-12">
        <div class="space-y-6 lg:col-span-8">
            <x-portal::card :title="'Images ('.count($product->gallery_images).')'">
                <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($product->gallery_images as $path)
                        <li><img src="{{ asset($path) }}" alt="" loading="lazy" class="aspect-square w-full rounded-md border border-slate-200 bg-white object-contain p-2"></li>
                    @endforeach
                </ul>
            </x-portal::card>

            <x-portal::card title="Description">
                @if ($product->description)
                    <div class="rich-text text-[0.9375rem]">{!! $product->description !!}</div>
                @else
                    <p class="text-[0.9375rem] text-slate-500">No description yet.</p>
                @endif
            </x-portal::card>

            <div class="grid gap-6 md:grid-cols-2">
                <x-portal::card title="Key features">
                    @if (! empty($product->features))
                        <ul class="list-disc space-y-1 pl-5 text-[0.9375rem] text-slate-700">
                            @foreach ($product->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-[0.9375rem] text-slate-500">No features listed.</p>
                    @endif
                </x-portal::card>

                <x-portal::card title="Specifications">
                    @if (! empty($product->specifications))
                        <dl class="divide-y divide-slate-200 text-[0.9375rem]">
                            @foreach ($product->specifications as $specification)
                                <div class="flex justify-between gap-4 py-2 first:pt-0 last:pb-0">
                                    <dt class="text-slate-500">{{ $specification['label'] }}</dt>
                                    <dd class="text-right font-medium text-slate-900">{{ $specification['value'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-[0.9375rem] text-slate-500">No specifications listed.</p>
                    @endif
                </x-portal::card>
            </div>
        </div>

        <div class="space-y-6 lg:col-span-4">
            <x-portal::card title="Details">
                <div class="flex flex-wrap gap-1">
                    @if ($product->is_active)
                        <x-portal::badge tone="success">Live on the website</x-portal::badge>
                    @else
                        <x-portal::badge>Hidden from visitors</x-portal::badge>
                    @endif
                    @if ($product->is_featured)
                        <x-portal::badge tone="brand"><x-lucide-star class="size-3" aria-hidden="true" /> Featured</x-portal::badge>
                    @endif
                </div>
                <dl class="divide-y divide-slate-200 text-[0.9375rem]">
                    @foreach ([
                        'Category' => $product->category?->name,
                        'Brand' => $product->brand ?: '—',
                        'Model number' => $product->model_number ?: '—',
                        'Display order' => $product->sort_order,
                        'URL slug' => $product->slug,
                        'Last updated' => $product->updated_at->format('j M Y, H:i'),
                    ] as $label => $value)
                        <div class="flex justify-between gap-4 py-2 first:pt-0 last:pb-0">
                            <dt class="text-slate-500">{{ $label }}</dt>
                            <dd class="text-right font-medium break-all text-slate-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-portal::card>

            <x-portal::card title="Datasheet">
                @if ($product->datasheet_path)
                    <a href="{{ asset($product->datasheet_path) }}" target="_blank" rel="noopener" class="flex items-center gap-2 text-[0.9375rem] font-medium text-brand-600 hover:text-brand-700">
                        <x-lucide-file-text class="size-5 shrink-0" aria-hidden="true" />
                        <span class="truncate">{{ basename($product->datasheet_path) }}</span>
                    </a>
                @else
                    <p class="text-[0.9375rem] text-slate-500">No datasheet uploaded.</p>
                @endif
            </x-portal::card>
        </div>
    </div>
</x-app-layout>
