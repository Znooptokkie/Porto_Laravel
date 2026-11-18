<?php

namespace App\Enums;

enum LeetcodeRatingFilter: string
{
    case Ascending = 'asc';
    case Descending = 'desc';
    case OneToTwo = '1-2';
    case TwoToThree = '2-3';
    case ThreeToFour = '3-4';
    case FourToFive = '4-5';
    case FiveToSix = '5-6';
    case SixToSeven = '6-7';
    case SevenToEight = '7-8';
    case EightToNine = '8-9';
    case NineToTen = '9-10';

    /**
     * The sort direction for the ascending and descending options, null for a rating range.
     */
    public function sortDirection(): ?string
    {
        return match ($this) {
            self::Ascending => 'asc',
            self::Descending => 'desc',
            default => null,
        };
    }

    /**
     * The inclusive lower and upper bound of a rating range, null for the sort options.
     *
     * @return array{0: int, 1: int}|null
     */
    public function range(): ?array
    {
        if ($this->sortDirection() !== null) {
            return null;
        }

        [$from, $to] = array_map(intval(...), explode('-', $this->value));

        return [$from, $to];
    }

    public function label(): string
    {
        return match ($this) {
            self::Ascending => __('leetcode.filters.rating_options.ascending'),
            self::Descending => __('leetcode.filters.rating_options.descending'),
            default => str_replace('-', ' - ', $this->value),
        };
    }
}
