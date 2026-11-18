<?php

namespace App\Models;

use App\Enums\LeetcodeConceptType;
use App\Enums\LeetcodeDifficulty;
use Database\Factories\LeetcodeProblemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $problem_number
 * @property string $name
 * @property string $url
 * @property int $rating
 * @property LeetcodeDifficulty $difficulty
 * @property string $language
 * @property string $runtime_ms
 * @property string $runtime_percentage
 * @property string $memory_mb
 * @property string $memory_percentage
 * @property string $code
 * @property-read Collection<int, LeetcodeConcept> $concepts
 */
#[Fillable(['problem_number', 'name', 'url', 'rating', 'difficulty', 'language', 'runtime_ms', 'runtime_percentage', 'memory_mb', 'memory_percentage', 'code'])]
class LeetcodeProblem extends Model
{
    /** @use HasFactory<LeetcodeProblemFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'problem_number' => 'integer',
            'rating' => 'integer',
            'difficulty' => LeetcodeDifficulty::class,
            'runtime_ms' => 'decimal:2',
            'runtime_percentage' => 'decimal:2',
            'memory_mb' => 'decimal:2',
            'memory_percentage' => 'decimal:2',
        ];
    }

    /**
     * The concepts (functions, methods, ...) this solution uses.
     *
     * @return BelongsToMany<LeetcodeConcept, $this, Pivot>
     */
    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(LeetcodeConcept::class);
    }

    /**
     * The colour band of a runtime or memory percentage: negative below 50, warning up to and including 85, positive above 85.
     */
    public static function percentageTone(float $percentage): string
    {
        return match (true) {
            $percentage < 50 => 'negative',
            $percentage > 85 => 'positive',
            default => 'warning',
        };
    }

    /**
     * The loaded concepts of one type. Relies on the `concepts` relation being eager loaded.
     *
     * @return Collection<int, LeetcodeConcept>
     */
    public function conceptsOfType(LeetcodeConceptType $type): Collection
    {
        return $this->concepts->where('type', $type)->values();
    }
}
