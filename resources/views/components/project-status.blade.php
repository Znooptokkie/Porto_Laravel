{{-- Status badge. The colours are fixed per status, in line with the Figma design, in both themes. --}}
@props(['status'])
<span class="project-status project-status--{{ $status->value }}">{{ $status->label() }}</span>
