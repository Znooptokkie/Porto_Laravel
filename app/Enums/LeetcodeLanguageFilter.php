<?php

namespace App\Enums;

enum LeetcodeLanguageFilter: string
{
    case Python = 'python';
    case Php = 'php';
    case JavaScript = 'javascript';

    /**
     * The stored languages this filter option covers. JavaScript and TypeScript solutions share one option.
     *
     * @return list<string>
     */
    public function databaseLanguages(): array
    {
        return match ($this) {
            self::Python => ['python'],
            self::Php => ['php'],
            self::JavaScript => ['javascript', 'typescript'],
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Python => 'Python',
            self::Php => 'PHP',
            self::JavaScript => 'JavaScript/TypeScript',
        };
    }
}
