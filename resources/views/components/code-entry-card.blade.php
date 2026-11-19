{{-- One entry with an optional heading, description and package, followed by its code block. The install commands of the package (Arch and/or Debian) get a copy button each. Used by the Linux commands and shell scripts pages. --}}
@props(['heading' => null, 'headingId' => null, 'description' => null, 'package' => null, 'installCommand' => null, 'installCommandDebian' => null, 'code', 'language' => 'bash'])
<article class="about-card code-entry-card" @if ($headingId) aria-labelledby="{{ $headingId }}" @endif>
    @if ($heading)
        <x-code-entry-heading :heading="$heading" :heading-id="$headingId" />
    @endif

    @if ($description)
        <p class="code-entry-card__description">{{ $description }}</p>
    @endif

    @if ($package)
        <ul class="code-entry-card__packages">
            <li><span class="code-entry-card__label">{{ __('code-entry.package') }}</span> {{ $package }}</li>

            @if ($installCommand || $installCommandDebian)
                <li class="code-entry-card__command-item">
                    <div class="code-entry-card__command-row">
                        <span class="code-entry-card__label">{{ __('code-entry.package_command') }}</span>

                        <div class="code-entry-card__installs">
                            @foreach (['Arch' => $installCommand, 'Debian' => $installCommandDebian] as $distribution => $command)
                                @if ($command)
                                    <div class="code-entry-card__install">
                                        <span class="code-entry-card__distribution">{{ $distribution }}</span>
                                        <code class="code-entry-card__install-command">{{ $command }}</code>
                                        <button type="button" class="code-entry-card__copy" data-copy-text="{{ $command }}" data-copy-label="{{ __('code-entry.copy') }}" data-copied-label="{{ __('code-entry.copied') }}" aria-label="{{ __('code-entry.copy') }}" title="{{ __('code-entry.copy') }}">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                                <rect x="9" y="9" width="13" height="13" rx="2" />
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif
        </ul>
    @endif

    <x-code-block :code="$code" :language="$language" />
</article>
