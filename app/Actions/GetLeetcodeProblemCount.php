<?php

namespace App\Actions;

use App\Models\LeetcodeProblem;

class GetLeetcodeProblemCount
{
    /**
     * Returns the number of problems shown on the LeetCode overview. A problem number counts once, even when its
     * solution is stored in several languages.
     */
    public function handle(): int
    {
        return LeetcodeProblem::query()->distinct()->count('problem_number');
    }
}
