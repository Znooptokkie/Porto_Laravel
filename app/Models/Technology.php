<?php

namespace App\Models;

use App\Enums\TechnologyKind;
use Database\Factories\TechnologyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property string $name
 * @property TechnologyKind $kind
 */
#[Fillable(['name', 'kind'])]
class Technology extends Model
{
    /** @use HasFactory<TechnologyFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kind' => TechnologyKind::class,
        ];
    }

    /**
     * Projects that show this technology on their overview card.
     *
     * @return BelongsToMany<Project, $this, Pivot>
     */
    public function cardProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->wherePivot('placement', 'card');
    }
}
