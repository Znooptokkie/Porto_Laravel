<?php

namespace App\Actions;

use App\Enums\LinuxCommandKeyword;
use App\Models\LinuxCommand;
use InvalidArgumentException;
use RuntimeException;

class ImportLinuxCommands
{
    /**
     * Upserts the Linux commands from a JSON file. Each entry needs a "command" and a "description"; "category",
     * "card_title", "keyword" and the English "card_title_en" and "description_en" are optional. They group the command
     * on the page and provide the English text. A keyword must be one of the
     * LinuxCommandKeyword values. The position of an entry in the file sets the order
     * on the page. A command that is already stored is updated instead of duplicated, so the import can be run again safely.
     *
     * @param  string  $path  A JSON file containing a list of {"category"?: string, "card_title"?: string, "card_title_en"?: string, "keyword"?: string, "command": string, "description": string, "description_en"?: string} objects.
     */
    public function handle(string $path): void
    {
        if (! is_file($path)) {
            throw new RuntimeException("Linux commands file not found: {$path}");
        }

        /** @var list<array{category?: mixed, card_title?: mixed, card_title_en?: mixed, keyword?: mixed, command?: mixed, description?: mixed, description_en?: mixed}> $entries */
        $entries = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        foreach ($entries as $index => $entry) {
            if (! is_string($entry['command'] ?? null) || ! is_string($entry['description'] ?? null)) {
                throw new InvalidArgumentException("Entry {$index} in {$path} needs a string \"command\" and \"description\".");
            }

            $keyword = $entry['keyword'] ?? null;

            if ($keyword !== null && LinuxCommandKeyword::tryFrom((string) $keyword) === null) {
                throw new InvalidArgumentException("Entry {$index} in {$path} has an unknown keyword \"{$keyword}\".");
            }

            LinuxCommand::query()->updateOrCreate(
                ['command' => $entry['command']],
                [
                    'category' => is_string($entry['category'] ?? null) ? $entry['category'] : null,
                    'card_title' => is_string($entry['card_title'] ?? null) ? $entry['card_title'] : null,
                    'keyword' => $keyword,
                    'card_title_en' => is_string($entry['card_title_en'] ?? null) ? $entry['card_title_en'] : null,
                    'description' => $entry['description'],
                    'description_en' => is_string($entry['description_en'] ?? null) ? $entry['description_en'] : null,
                    'position' => $index,
                ],
            );
        }
    }
}
