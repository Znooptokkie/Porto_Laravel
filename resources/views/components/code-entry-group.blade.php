{{-- One card with several code entries. Each entry has a description with an accent bullet, followed by its code block. --}}
@props(['heading' => null, 'headingId' => null, 'entries'])
<article class="about-card code-entry-card code-entry-group" @if ($headingId) aria-labelledby="{{ $headingId }}" @endif>
    @if ($heading)
        <x-code-entry-heading :heading="$heading" :heading-id="$headingId" accent="first" />
    @endif

    <ul class="code-entry-card__items">
        @foreach ($entries as $entry)
            <li>
                <p>{{ $entry->localizedDescription() }}</p>
                <x-code-block :code="$entry->command" language="bash" />
            </li>
        @endforeach
    </ul>
</article>
