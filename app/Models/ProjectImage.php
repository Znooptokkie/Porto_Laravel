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
 * @property list<array{path: string, alt: string|null, translations: array<string, array<string, string>>|null}>|null $mobile_photos Cropped photos shown instead of this photo on screens up to 600px, in order. Empty uses this photo on every screen.
 * @property array<string, array<string, string>>|null $translations
 * @property int $sort_order
 */
#[Fillable(['project_id', 'path', 'alt', 'caption', 'mobile_photos', 'translations', 'sort_order'])]
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
            'mobile_photos' => 'array',
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

    /**
     * The alt text of a mobile photo in the active locale, or null when it has none; the viewer then uses the alt text of the main photo.
     *
     * @param  array{path: string, alt: string|null, translations: array<string, array<string, string>>|null}  $mobilePhoto
     */
    public function mobilePhotoAlt(array $mobilePhoto): ?string
    {
        $translation = $mobilePhoto['translations'][app()->getLocale()]['alt'] ?? null;

        return $translation !== null && $translation !== '' ? $translation : $mobilePhoto['alt'];
    }
}
