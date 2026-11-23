{{-- The result count above a filtered list. The number takes the accent colour. It stays hidden until a filter is active. --}}
@props(['count', 'translationKey', 'hidden' => false])
@php
    $countText = trans_choice($translationKey, $count, ['count' => '<span class="results-count__number">'.$count.'</span>']);
@endphp
<p class="results-count" data-project-count{{ $hidden ? ' hidden' : '' }}>{!! $countText !!}</p>
