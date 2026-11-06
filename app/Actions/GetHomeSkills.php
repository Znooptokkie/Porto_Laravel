<?php

namespace App\Actions;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class GetHomeSkills
{
    /**
     * Returns the first ten skills, ordered by id, in a single query.
     *
     * @return Collection<int, Skill>
     */
    public function handle(): Collection
    {
        return Skill::query()
            ->orderBy('id')
            ->limit(10)
            ->get();
    }
}
