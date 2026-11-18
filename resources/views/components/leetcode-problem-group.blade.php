{{-- One problem number. A problem solved in one language shows its cards directly; a problem solved in several languages gets one tab per language above its cards. --}}
@props(['group', 'position'])
@php
    $languages = $group['languages'];
    $hasTabs = count($languages) > 1;
    $groupId = 'leetcode-group-'.$position;
@endphp
<div class="leetcode-group" @if ($hasTabs) data-leetcode-group @endif>
    @if ($hasTabs)
        <div class="leetcode-group__tabs" role="tablist" aria-label="{{ __('leetcode.filters.language') }}">
            @foreach (array_keys($languages) as $language)
                <button type="button" class="leetcode-group__tab" role="tab" id="{{ $groupId }}-tab-{{ $loop->index }}" aria-controls="{{ $groupId }}-panel-{{ $loop->index }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? 0 : -1 }}" data-leetcode-tab>{{ ucfirst($language) }}</button>
            @endforeach
        </div>
    @endif

    @foreach ($languages as $problems)
        <div class="leetcode-group__panel" @if ($hasTabs) role="tabpanel" id="{{ $groupId }}-panel-{{ $loop->index }}" aria-labelledby="{{ $groupId }}-tab-{{ $loop->index }}" @if (! $loop->first) hidden @endif @endif>
            @foreach ($problems as $problem)
                <x-leetcode-problem-card :problem="$problem" :position="$position.'-'.$loop->parent->index.'-'.$loop->index" />
            @endforeach
        </div>
    @endforeach
</div>
