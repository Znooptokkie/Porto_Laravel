{{-- A code block with a copy button in its top right corner. Used by the code entry cards. --}}
@props(['code', 'language' => 'bash'])
<div class="code-entry-card__code">
    <button type="button" class="code-entry-card__copy code-entry-card__copy--code" data-copy-text="{{ $code }}" data-copy-label="{{ __('code-entry.copy_code') }}" data-copied-label="{{ __('code-entry.copied_code') }}" aria-label="{{ __('code-entry.copy_code') }}" title="{{ __('code-entry.copy_code') }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <rect x="9" y="9" width="13" height="13" rx="2" />
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
        </svg>
    </button>
    <pre class="leetcode-solution"><code class="language-{{ $language }}">{{ $code }}</code></pre>
</div>
