{{-- One LeetCode problem: its metrics, the concepts it uses, a link to the problem and the Prism-highlighted solution. --}}
@props(['problem', 'position'])
@php
    use App\Enums\LeetcodeConceptType;

    $titleId = 'leetcode-problem-'.$position.'-title';
    $difficulty = $problem->difficulty->value;
    $runtimeTone = $problem::percentageTone((float) $problem->runtime_percentage);
    $memoryTone = $problem::percentageTone((float) $problem->memory_percentage);
@endphp
<article class="leetcode-card about-card" aria-labelledby="{{ $titleId }}">
    <header class="leetcode-card__heading">
        <h3 class="leetcode-card__title" id="{{ $titleId }}">
            <span class="leetcode-card__number">{{ $problem->problem_number }}.</span> {{ $problem->name }}
        </h3>
        <p class="leetcode-card__difficulty">
            <span>{{ __('leetcode.difficulty.'.$difficulty) }}</span>
            <x-themed-image class="leetcode-card__difficulty-icon" :light="'images/leetcode/icons/difficulty-'.$difficulty.'.svg'" :dark="'images/leetcode/icons/dark/difficulty-'.$difficulty.'.svg'" />
        </p>
    </header>

    <div class="leetcode-card__metrics">
        <dl class="leetcode-metric-group">
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.language') }}</dt>
                <dd>{{ ucfirst($problem->language) }}</dd>
            </div>
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.rating') }}</dt>
                <dd>{{ number_format($problem->rating, 1, '.', '') }}/10</dd>
            </div>
        </dl>

        <dl class="leetcode-metric-group">
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.runtime') }}</dt>
                <dd>{{ number_format($problem->runtime_ms, 2, '.', '') }}</dd>
            </div>
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.runtime_percentage') }}</dt>
                <dd class="leetcode-metric__value leetcode-metric__value--{{ $runtimeTone }}">{{ number_format($problem->runtime_percentage, 2, '.', '') }}%</dd>
            </div>
        </dl>

        <dl class="leetcode-metric-group">
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.memory') }}</dt>
                <dd>{{ number_format($problem->memory_mb, 2, '.', '') }}</dd>
            </div>
            <div class="leetcode-metric">
                <dt>{{ __('leetcode.card.memory_percentage') }}</dt>
                <dd class="leetcode-metric__value leetcode-metric__value--{{ $memoryTone }}">{{ number_format($problem->memory_percentage, 2, '.', '') }}%</dd>
            </div>
        </dl>
    </div>

    <div class="leetcode-card__concepts">
        @foreach (LeetcodeConceptType::cases() as $type)
            @php
                $concepts = $problem->conceptsOfType($type);
            @endphp
            @continue($concepts->isEmpty())
            <section class="leetcode-concept">
                <h4 class="leetcode-concept__title">{{ __('leetcode.card.'.$type->translationKey()) }}</h4>
                <ul class="leetcode-concept__list">
                    @foreach ($concepts as $concept)
                        <li class="leetcode-concept__item">{{ $concept->name }}</li>
                    @endforeach
                </ul>
            </section>
        @endforeach
    </div>

    <a class="leetcode-card__link" href="{{ $problem->url }}" target="_blank" rel="noopener noreferrer">
        <span>{{ __('leetcode.card.link') }}</span><span aria-hidden="true"> &gt;</span>
        <span class="visually-hidden">{{ __('leetcode.card.link_new_tab') }}</span>
    </a>

    <pre class="leetcode-solution"><code class="language-{{ $problem->language }}">{{ $problem->code }}</code></pre>
</article>
