@props(['skill'])
<article class="skill-card">
    <div class="skill-card__icon {{ $skill->display_label === 'Sass' ? 'skill-card__icon--text-italic' : '' }}" aria-hidden="true">
        @if ($skill->icon)
            <x-skill-icon :icon="$skill->icon" />
        @else
            {{ $skill->display_label ?? $skill->name }}
        @endif
    </div>
    <div class="skill-card__head">
        <p class="skill-card__name">{{ $skill->name }}</p>
        <span class="skill-card__bar" aria-hidden="true">
            <span class="skill-card__bar-fill" style="width: {{ (int) $skill->proficiency }}%"></span>
        </span>
    </div>
    @if (! empty($skill->subconcepts))
        <p class="skill-card__subconcepts">{{ implode(' - ', $skill->subconcepts) }}</p>
    @endif
</article>
