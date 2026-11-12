<?php

namespace App\Models;

use Database\Factories\ProjectImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $project_id
 * @property string $path
 * @property string|null $alt
 * @property string|null $caption
 * @property array<string, array<string, string>>|null $translations
 * @property int $sort_order
 */
#[Fillable(['project_id', 'path', 'alt', 'caption', 'translations', 'sort_order'])]
class ProjectImage extends Model
{
    /** @use HasFactory<ProjectImageFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'translations' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Returns the stored value of an attribute in the active locale, or the Dutch original when no non-empty translation exists.
     */
    public function translated(string $attribute): ?string
    {
        $translation = $this->translations[app()->getLocale()][$attribute] ?? null;

        return $translation !== null && $translation !== '' ? $translation : $this->{$attribute};
    }
}
