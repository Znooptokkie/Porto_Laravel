<?php

namespace App\Actions;

use App\Enums\LinuxCommandKeyword;
use App\Models\LinuxCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetLinuxCommands
{
    /**
     * Returns the Linux commands grouped by category and then by card, in the order of their position, together with the
     * total number of stored commands. When a search term is given, every word of it must appear in the category, the
     * card title or the code of a command. When a keyword is given, only the commands with that keyword are returned. A
     * category without a name and a card without a title are grouped under the empty string.
     *
     * @return array{categories: Collection<int|string, Collection<int|string, Collection<int, LinuxCommand>>>, commandCount: int}
     */
    public function handle(?string $search = null, ?LinuxCommandKeyword $keyword = null): array
    {
        $words = preg_split('/\s+/', trim((string) $search), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $commands = LinuxCommand::query()
            ->when($keyword !== null, fn (Builder $query) => $query->where('keyword', $keyword->value))
            ->when($words !== [], function (Builder $query) use ($words): void {
                foreach ($words as $word) {
                    $query->where(fn (Builder $wordQuery) => $wordQuery
                        ->whereLike('category', '%'.$word.'%')
                        ->orWhereLike('card_title', '%'.$word.'%')
                        ->orWhereLike('command', '%'.$word.'%'));
                }
            })
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        $categories = $commands->toBase()
            ->groupBy(fn (LinuxCommand $command): string => (string) $command->category)
            ->map(fn (Collection $categoryCommands): Collection => $categoryCommands
                ->groupBy(fn (LinuxCommand $command): string => (string) $command->card_title));

        return [
            'categories' => $categories,
            'commandCount' => LinuxCommand::query()->count(),
        ];
    }
}
