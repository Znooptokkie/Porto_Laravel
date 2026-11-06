{{-- Renders the light and dark Figma export of one icon; the stylesheet shows the variant for the active theme.
     SVG exports are inlined so their accent parts (currentColor) follow the accent colour. A PNG marked `accent`
     is a monochrome alpha mask filled with the accent colour. Other PNGs are plain images. --}}
@props(['light', 'dark', 'class' => null, 'accent' => false])
@foreach (['themed-image__light' => $light, 'themed-image__dark' => $dark] as $variantClass => $path)
    @php
        $classes = trim('themed-image '.$variantClass.' '.$class);
        $uniquePrefix = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(8));
        $inlineSvg = str_ends_with($path, '.svg')
            ? file_get_contents(public_path($path))
            : null;
        if ($inlineSvg !== null) {
            $inlineSvg = preg_replace('/(?<=\s)id="([^"]+)"/', 'id="'.$uniquePrefix.'-$1"', $inlineSvg);
            $inlineSvg = preg_replace('/url\(#([^)]+)\)/', 'url(#'.$uniquePrefix.'-$1)', $inlineSvg);
            $inlineSvg = \Illuminate\Support\Str::replaceFirst(
                '<svg',
                '<svg class="'.e($classes).'" aria-hidden="true" focusable="false" '.(string) $attributes,
                $inlineSvg,
            );
        }
    @endphp
    @if ($inlineSvg !== null)
        {!! $inlineSvg !!}
    @elseif ($accent)
        <span class="{{ $classes }} themed-image--mask" style="--themed-image-mask: url('{{ asset($path) }}')" aria-hidden="true" {{ $attributes }}></span>
    @else
        <img class="{{ $classes }}" src="{{ asset($path) }}" alt="" aria-hidden="true" {{ $attributes }}>
    @endif
@endforeach
