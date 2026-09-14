@props(['partners'])

{{--
    Each logo gets the same visual area rather than the same height, so wide
    wordmarks (Hikvision) and compact marks (Cisco) carry equal weight.
--}}
<ul {{ $attributes->class('grid grid-cols-2 border-t border-l border-slate-200 sm:grid-cols-3 lg:grid-cols-6') }}>
    @foreach ($partners as $partner)
        @php
            $displayWidth = round(sqrt(14 * $partner['width'] / $partner['height']) * ($partner['scale'] ?? 1), 2);
        @endphp
        <li class="flex aspect-[3/2] items-center justify-center border-r border-b border-slate-200 bg-white p-5 sm:p-6">
            <img
                src="{{ asset($partner['logo']) }}"
                alt="{{ $partner['name'] }}"
                width="{{ $partner['width'] }}"
                height="{{ $partner['height'] }}"
                loading="lazy"
                style="width: {{ $displayWidth }}rem"
                class="h-auto max-w-full object-contain"
            >
        </li>
    @endforeach
</ul>
