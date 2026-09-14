@props([
    'variant' => 'rule',   // rule | mark | hero
    'tone' => 'light',     // light (on white) | dark (on brand-900)
    'animate' => false,
])

@php
    $isDark = $tone === 'dark';
    $blue = $isDark ? '#6E99E0' : '#4A79D4';
    $ink = $isDark ? 'rgb(255 255 255 / 0.9)' : '#141A23';
    $quiet = $isDark ? 'rgb(255 255 255 / 0.18)' : '#D8DEE7';

    // The logo mark: nine bars, symmetric, alternating ink and blue.
    $logoHeights = [0.33, 0.47, 0.62, 0.82, 1, 0.82, 0.62, 0.47, 0.33];
    $logoInk = [0, 3, 5, 8];

    $bars = [];

    if ($variant === 'mark') {
        foreach ($logoHeights as $i => $h) {
            $bars[] = ['h' => $h, 'color' => in_array($i, $logoInk, true) ? $ink : $blue];
        }
        $barWidth = 3; $gap = 4; $height = 40;
    } elseif ($variant === 'hero') {
        // Three logo pulses of different amplitude, joined by low signal.
        $pattern = [0.12, 0.2, 0.14, ...array_map(fn ($h) => $h * 0.7, $logoHeights), 0.18, 0.1, 0.22, ...$logoHeights, 0.16, 0.24, 0.12, ...array_map(fn ($h) => $h * 0.55, $logoHeights), 0.14, 0.2, 0.1];
        foreach ($pattern as $i => $h) {
            $bars[] = ['h' => $h, 'color' => $h >= 0.5 ? ($i % 3 === 0 ? $ink : $blue) : $quiet];
        }
        $barWidth = 4; $gap = 5; $height = 64;
    } else {
        // Full-width rule: deterministic pseudo-signal, with pulses echoing the logo.
        $count = 240;
        for ($i = 0; $i < $count; $i++) {
            $noise = (sin($i * 1.7) + sin($i * 0.37 + 1.3) + sin($i * 2.9 + 0.4)) / 3;
            $h = 0.16 + 0.12 * abs($noise);
            $distance = ($i % 40) - 20;
            if (abs($distance) <= 4) {
                $h = max($h, $logoHeights[$distance + 4] * (0.55 + 0.45 * abs(sin($i / 40 * 2.1))));
            }
            $bars[] = ['h' => round($h, 3), 'color' => $h >= 0.5 ? (abs($distance) % 3 === 0 ? $ink : $blue) : $quiet];
        }
        $barWidth = 2; $gap = 8; $height = 36;
    }

    $width = count($bars) * ($barWidth + $gap) - $gap;
@endphp

<svg
    {{ $attributes->class([$animate ? 'waveform-animate' : null, 'block']) }}
    viewBox="0 0 {{ $width }} {{ $height }}"
    @if ($variant === 'rule') preserveAspectRatio="xMidYMid slice" @else width="{{ $width }}" height="{{ $height }}" @endif
    aria-hidden="true"
    focusable="false"
>
    @if ($animate)
        @foreach ($bars as $i => $bar)
            @php $barHeight = max(2, $bar['h'] * $height); @endphp
            <rect class="waveform-bar" style="--i:{{ $i }}" x="{{ $i * ($barWidth + $gap) }}" y="{{ round(($height - $barHeight) / 2, 2) }}" width="{{ $barWidth }}" height="{{ round($barHeight, 2) }}" rx="{{ $barWidth / 2 }}" fill="{{ $bar['color'] }}"/>
        @endforeach
    @else
        @php
            // One stroked path per colour keeps long rules light.
            $paths = collect($bars)->map(function (array $bar, int $i) use ($barWidth, $gap, $height): array {
                $barHeight = max($barWidth, $bar['h'] * $height) - $barWidth;
                $x = $i * ($barWidth + $gap) + $barWidth / 2;
                $y = round(($height - $barHeight) / 2, 1);

                return ['color' => $bar['color'], 'd' => 'M'.$x.' '.$y.'v'.round($barHeight, 1)];
            })->groupBy('color')->map(fn ($group) => $group->pluck('d')->implode(''));
        @endphp
        @foreach ($paths as $color => $d)
            <path d="{{ $d }}" stroke="{{ $color }}" stroke-width="{{ $barWidth }}" stroke-linecap="round" fill="none"/>
        @endforeach
    @endif
</svg>
