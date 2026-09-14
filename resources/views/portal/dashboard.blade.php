<x-app-layout title="Dashboard">
    <x-portal::page-header
        :title="'Welcome back, '.Str::before(Auth::user()->name, ' ')"
        description="Keep the portfolio and product catalogue on the website up to date."
    >
        <x-slot:actions>
            <x-button :href="route('portal.projects.create')" variant="secondary" icon="plus">Add project</x-button>
            <x-button :href="route('portal.products.create')" icon="plus">Add product</x-button>
        </x-slot:actions>
    </x-portal::page-header>

    <dl class="grid grid-cols-2 overflow-hidden rounded-lg border border-slate-200 bg-slate-200 gap-px lg:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="bg-white px-5 py-5">
                <dt class="text-meta text-slate-500">{{ $stat['label'] }}</dt>
                <dd class="mt-1 font-display text-3xl font-semibold tracking-[-0.02em] text-slate-900">
                    @if ($stat['route'])
                        <a href="{{ route($stat['route']) }}" class="transition-colors duration-[120ms] hover:text-brand-600">{{ number_format($stat['figure']) }}</a>
                    @else
                        {{ number_format($stat['figure']) }}
                    @endif
                </dd>
            </div>
        @endforeach
    </dl>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <x-portal::card title="Recently updated projects">
            <x-slot:actions>
                <a href="{{ route('portal.projects.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">View all</a>
            </x-slot:actions>

            @forelse ($recentProjects as $project)
                <a href="{{ route('portal.projects.show', $project) }}" class="-mx-2 flex items-center gap-4 rounded-md px-2 py-1 transition-colors duration-[120ms] hover:bg-slate-50">
                    <img src="{{ $project->image_url }}" alt="" loading="lazy" class="h-12 w-16 shrink-0 rounded-md border border-slate-200 object-cover">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-[0.9375rem] font-medium text-slate-900">{{ $project->title }}</span>
                        <span class="block text-sm text-slate-500">{{ $project->sector }} · updated {{ $project->updated_at->diffForHumans() }}</span>
                    </span>
                    <x-lucide-chevron-right class="size-4 shrink-0 text-slate-400" aria-hidden="true" />
                </a>
            @empty
                <p class="text-[0.9375rem] text-slate-500">No projects yet. <a href="{{ route('portal.projects.create') }}" class="font-semibold text-brand-600 hover:text-brand-700">Add the first one</a>.</p>
            @endforelse
        </x-portal::card>

        <x-portal::card title="Recently updated products">
            <x-slot:actions>
                <a href="{{ route('portal.products.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">View all</a>
            </x-slot:actions>

            @forelse ($recentProducts as $product)
                <a href="{{ route('portal.products.show', $product) }}" class="-mx-2 flex items-center gap-4 rounded-md px-2 py-1 transition-colors duration-[120ms] hover:bg-slate-50">
                    <img src="{{ $product->image_url }}" alt="" loading="lazy" class="size-12 shrink-0 rounded-md border border-slate-200 bg-white object-contain">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-[0.9375rem] font-medium text-slate-900">{{ $product->name }}</span>
                        <span class="block text-sm text-slate-500">{{ $product->category?->name }} · updated {{ $product->updated_at->diffForHumans() }}</span>
                    </span>
                    @unless ($product->is_active)
                        <x-portal::badge>Hidden</x-portal::badge>
                    @endunless
                </a>
            @empty
                <p class="text-[0.9375rem] text-slate-500">No products yet. <a href="{{ route('portal.products.create') }}" class="font-semibold text-brand-600 hover:text-brand-700">Add the first one</a>.</p>
            @endforelse
        </x-portal::card>
    </div>
</x-app-layout>
