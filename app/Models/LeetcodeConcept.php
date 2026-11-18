<?php

namespace App\Models;

use App\Enums\LeetcodeConceptType;
use Database\Factories\LeetcodeConceptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property LeetcodeConceptType $type
 * @property string $name
 * @property string|null $description
 */
#[Fillable(['type', 'name', 'description'])]
class LeetcodeConcept extends Model
{
    /** @use HasFactory<LeetcodeConceptFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => LeetcodeConceptType::class,
        ];
    }

    /**
     * @return BelongsToMany<LeetcodeProblem, $this, Pivot>
     */
    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(LeetcodeProblem::class);
    }
}
