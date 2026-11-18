<?php

namespace App\Enums;

/**
 * The options of the runtime and memory filters: a sort on the absolute value or on the percentage, or a percentage band.
 */
enum LeetcodeMetricFilter: string
{
    case Ascending = 'asc';
    case Descending = 'desc';
    case AscendingPercentage = 'asc-percentage';
    case DescendingPercentage = 'desc-percentage';
    case BelowFifty = 'below-50';
    case BelowEightyFive = 'below-85';
    case AboveEightyFive = 'above-85';

    /**
     * The sort direction for the four sort options, null for the percentage bands.
     */
    public function sortDirection(): ?string
    {
        return match ($this) {
            self::Ascending, self::AscendingPercentage => 'asc',
            self::Descending, self::DescendingPercentage => 'desc',
            default => null,
        };
    }

    /**
     * Whether the option works on the percentage column rather than on the absolute value.
     */
    public function isPercentage(): bool
    {
        return ! in_array($this, [self::Ascending, self::Descending], true);
    }

    /**
     * The comparison a percentage band applies to the percentage column, null for the sort options.
     *
     * @return array{operator: string, value: int}|null
     */
    public function percentageCondition(): ?array
    {
        return match ($this) {
            self::BelowFifty => ['operator' => '<', 'value' => 50],
            self::BelowEightyFive => ['operator' => '<', 'value' => 85],
            self::AboveEightyFive => ['operator' => '>', 'value' => 85],
            default => null,
        };
    }

    /**
     * @param  string  $unit  The unit of the absolute value, such as ms or MB.
     */
    public function label(string $unit): string
    {
        return match ($this) {
            self::Ascending => __('leetcode.filters.metric_options.ascending', ['unit' => $unit]),
            self::Descending => __('leetcode.filters.metric_options.descending', ['unit' => $unit]),
            self::AscendingPercentage => __('leetcode.filters.metric_options.ascending_percentage'),
            self::DescendingPercentage => __('leetcode.filters.metric_options.descending_percentage'),
            self::BelowFifty => '< 50%',
            self::BelowEightyFive => '< 85%',
            self::AboveEightyFive => '> 85%',
        };
    }
}
