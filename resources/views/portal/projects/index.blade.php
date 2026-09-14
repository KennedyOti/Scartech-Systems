<x-app-layout title="Portfolio projects">
    <x-portal::page-header title="Portfolio projects" description="Case studies shown on the Portfolio page, in display order.">
        <x-slot:actions>
            <x-button :href="route('portal.projects.create')" icon="plus">Add project</x-button>
        </x-slot:actions>
    </x-portal::page-header>

    <form method="GET" action="{{ route('portal.projects.index') }}" role="search" class="mb-5 flex max-w-md gap-2">
        <label for="search" class="sr-only">Search projects</label>
        <div class="relative flex-1">
            <x-lucide-search class="pointer-events-none absolute top-1/2 left-3 size-[1.125rem] -translate-y-1/2 text-slate-400" aria-hidden="true" />
            <input type="search" id="search" name="search" value="{{ $search }}" placeholder="Search by title, sector or client" class="block min-h-11 w-full rounded-md border border-slate-300 bg-white py-2 pr-3 pl-10 text-[0.9375rem] text-slate-900 placeholder:text-slate-400 transition-colors duration-[120ms] hover:border-slate-400 focus:outline-2 focus:outline-offset-0 focus:outline-brand-600">
        </div>
        <x-button type="submit" variant="secondary">Search</x-button>
    </form>

    @if ($projects->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
            <x-lucide-folder-kanban class="mx-auto size-8 text-slate-400" aria-hidden="true" />
            @if ($search !== '')
                <p class="mt-3 font-medium text-slate-900">No projects match “{{ $search }}”.</p>
                <a href="{{ route('portal.projects.index') }}" class="mt-2 inline-block text-sm font-semibold text-brand-600 hover:text-brand-700">Clear search</a>
            @else
                <p class="mt-3 font-medium text-slate-900">No portfolio projects yet.</p>
                <p class="mt-1 text-sm text-slate-500">Projects you add appear on the website’s Portfolio page.</p>
                <x-button :href="route('portal.projects.create')" icon="plus" class="mt-5">Add project</x-button>
            @endif
        </div>
    @else
        <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
            <table class="w-full min-w-[44rem] text-left text-[0.9375rem]">
                <thead class="border-b border-slate-200 bg-slate-50 text-meta text-slate-500">
                    <tr>
                        <th scope="col" class="px-5 py-3 font-medium">Project</th>
                        <th scope="col" class="px-5 py-3 font-medium">Sector</th>
                        <th scope="col" class="px-5 py-3 font-medium">Services</th>
                        <th scope="col" class="px-5 py-3 font-medium">Order</th>
                        <th scope="col" class="px-5 py-3 text-right font-medium"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($projects as $project)
                        <tr class="transition-colors duration-[120ms] hover:bg-slate-25">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $project->image_url }}" alt="" loading="lazy" class="h-12 w-16 shrink-0 rounded-md border border-slate-200 object-cover">
                                    <div class="min-w-0">
                                        <a href="{{ route('portal.projects.show', $project) }}" class="font-medium text-slate-900 hover:text-brand-600">{{ $project->title }}</a>
                                        <div class="mt-0.5 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                                            {{ $project->location }}
                                            @if ($project->is_featured)
                                                <x-portal::badge tone="brand"><x-lucide-star class="size-3" aria-hidden="true" /> Featured</x-portal::badge>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-700">{{ $project->sector }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $project->services_count }}</td>
                            <td class="px-5 py-3 text-slate-700 tabular-nums">{{ $project->sort_order }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('portal.projects.show', $project) }}" class="inline-flex size-9 items-center justify-center rounded-md text-slate-500 transition-colors duration-[120ms] hover:bg-slate-100 hover:text-slate-900" title="View">
                                        <x-lucide-eye class="size-[1.125rem]" aria-hidden="true" /><span class="sr-only">View {{ $project->title }}</span>
                                    </a>
                                    <a href="{{ route('portal.projects.edit', $project) }}" class="inline-flex size-9 items-center justify-center rounded-md text-slate-500 transition-colors duration-[120ms] hover:bg-slate-100 hover:text-slate-900" title="Edit">
                                        <x-lucide-pencil class="size-[1.125rem]" aria-hidden="true" /><span class="sr-only">Edit {{ $project->title }}</span>
                                    </a>
                                    <x-portal::delete-button
                                        :action="route('portal.projects.destroy', $project)"
                                        :confirm="'Delete “'.$project->title.'”? Its photographs will be removed too.'"
                                        :label="'Delete '.$project->title"
                                        icon-only
                                    />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $projects->links() }}
    @endif
</x-app-layout>
