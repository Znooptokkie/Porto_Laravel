<?php

namespace App\Actions;

use App\Models\ShellScript;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetShellScripts
{
    /**
     * Returns the shell scripts in the order they were added, together with the total number of stored scripts. When a
     * search term is given, every word of it must appear in the title, the file name or the code of a script. A single
     * letter is a valid word.
     *
     * @return array{scripts: Collection<int, ShellScript>, totalCount: int}
     */
    public function handle(?string $search = null): array
    {
        $words = preg_split('/\s+/', trim((string) $search), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $scripts = ShellScript::query()
            ->when($words !== [], function (Builder $query) use ($words): void {
                foreach ($words as $word) {
                    $query->where(fn (Builder $wordQuery) => $wordQuery
                        ->whereLike('title', '%'.$word.'%')
                        ->orWhereLike('name', '%'.$word.'%')
                        ->orWhereLike('code', '%'.$word.'%'));
                }
            })
            ->orderBy('id')
            ->get();

        return [
            'scripts' => $scripts,
            'totalCount' => ShellScript::query()->count(),
        ];
    }
}
