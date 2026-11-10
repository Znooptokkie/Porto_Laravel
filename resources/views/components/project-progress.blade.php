{{-- Nine-part progress marker. Segments up to the project's position are filled. --}}
@props(['position', 'total'])
<span class="project-progress" aria-hidden="true">
    @for ($segment = 1; $segment <= $total; $segment++)
        <span class="project-progress__segment{{ $segment <= $position ? ' project-progress__segment--filled' : '' }}"></span>
    @endfor
</span>
