@props(['clients'])

{{--
    Logos get the same visual area rather than the same height (see partner-wall), so wide wordmarks and
    square crests carry equal weight. Clients without a logo file render as a name tile.
--}}
<ul {{ $attributes->class('grid grid-cols-2 border-t border-l border-slate-200 sm:grid-cols-4 lg:grid-cols-5') }}>
    @foreach ($clients as $client)
        <li class="flex aspect-[3/2] items-center justify-center border-r border-b border-slate-200 bg-white p-5 sm:p-6">
            @if ($client->logo && $client->logo_width && $client->logo_height)
                <img
                    src="{{ asset($client->logo) }}"
                    alt="{{ $client->name }}"
                    title="{{ $client->name }}"
                    width="{{ $client->logo_width }}"
                    height="{{ $client->logo_height }}"
                    loading="lazy"
                    style="width: {{ round(min(sqrt(20 * $client->logo_width / $client->logo_height), 11), 2) }}rem"
                    class="h-auto max-h-full max-w-full object-contain"
                >
            @else
                <span class="text-center text-[0.9375rem] leading-snug font-semibold text-balance text-slate-700">{{ $client->name }}</span>
            @endif
        </li>
    @endforeach
</ul>
