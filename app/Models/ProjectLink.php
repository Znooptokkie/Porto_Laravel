<?php

namespace App\Models;

use Database\Factories\ProjectLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $project_id
 * @property string $description
 * @property string $url
 * @property array<string, array<string, string>>|null $translations
 * @property int $sort_order
 */
#[Fillable(['project_id', 'description', 'url', 'translations', 'sort_order'])]
class ProjectLink extends Model
{
    /** @use HasFactory<ProjectLinkFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'translations' => 'array',
        ];
    }

    /**
     * The short description in the active locale, falling back to the Dutch description.
     */
    public function translatedDescription(): string
    {
        return $this->translations[app()->getLocale()]['description'] ?? $this->description;
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
