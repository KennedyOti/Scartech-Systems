@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mt-12 flex items-center justify-between gap-4 border-t border-slate-200 pt-6">
        @if ($paginator->onFirstPage())
            <span class="inline-flex min-h-11 items-center gap-2 px-1 text-[0.9375rem] font-medium text-slate-400" aria-disabled="true">
                <x-lucide-chevron-left class="size-4" aria-hidden="true" /> Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex min-h-11 items-center gap-2 rounded-md px-1 text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                <x-lucide-chevron-left class="size-4" aria-hidden="true" /> Previous
            </a>
        @endif

        <ul class="hidden items-center gap-1 sm:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-2 text-slate-500">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex size-11 items-center justify-center rounded-md bg-brand-600 text-[0.9375rem] font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" aria-label="Go to page {{ $page }}" class="inline-flex size-11 items-center justify-center rounded-md text-[0.9375rem] font-medium text-slate-700 hover:bg-slate-50">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>

        <p class="text-sm text-slate-500 sm:hidden">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</p>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex min-h-11 items-center gap-2 rounded-md px-1 text-[0.9375rem] font-semibold text-brand-600 hover:text-brand-700">
                Next <x-lucide-chevron-right class="size-4" aria-hidden="true" />
            </a>
        @else
            <span class="inline-flex min-h-11 items-center gap-2 px-1 text-[0.9375rem] font-medium text-slate-400" aria-disabled="true">
                Next <x-lucide-chevron-right class="size-4" aria-hidden="true" />
            </span>
        @endif
    </nav>
@endif
