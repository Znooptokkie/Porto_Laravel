{{-- One chapter of the project story: milestone, numbered label, title and paragraphs. --}}
@props(['chapter', 'number', 'projectTitle'])
<li class="project-chapter">
    <div class="project-chapter__marker">
        <x-themed-image class="project-icon project-chapter__dot" :light="'images/projects/icons/imgMilestone.svg'" :dark="'images/projects/icons/imgMilestone.svg'" />
        <p class="project-chapter__number">{{ __('projects.detail.chapter', ['number' => str_pad((string) $number, 2, '0', STR_PAD_LEFT), 'project' => str($projectTitle)->upper()]) }}</p>
        <h3 class="project-chapter__title">{{ $chapter->translatedTitle() }}</h3>
    </div>
    <div class="project-chapter__body">
        <div class="project-chapter__text">
            @foreach ($chapter->translatedParagraphs() as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
</li>
