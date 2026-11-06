{{-- Inlines the light and dark SVG of a skill. Falls back to a neutral placeholder when the file is missing. --}}
@props(['icon' => null])
@php
    $lightPath = resource_path("svg/skills/light/{$icon}.svg");
    $darkPath = resource_path("svg/skills/dark/{$icon}.svg");
    $hasIcon = $icon !== null && is_file($lightPath) && is_file($darkPath);
@endphp
@if ($hasIcon)
    <span class="themed-image__light" aria-hidden="true">{!! file_get_contents($lightPath) !!}</span>
    <span class="themed-image__dark" aria-hidden="true">{!! file_get_contents($darkPath) !!}</span>
@else
    <svg class="placeholder-icon" width="37" height="37" viewBox="0 0 37 37" fill="none" aria-hidden="true" focusable="false">
        <rect x="1" y="1" width="35" height="35" rx="6" stroke="currentColor" stroke-dasharray="4 3" />
    </svg>
@endif
