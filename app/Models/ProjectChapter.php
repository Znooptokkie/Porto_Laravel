<?php

namespace App\Models;

use Database\Factories\ProjectChapterFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property array<int, string> $paragraphs
 * @property int $sort_order
 * @property array<string, array<string, mixed>>|null $translations
 */
#[Fillable(['project_id', 'title', 'paragraphs', 'sort_order', 'translations'])]
class ProjectChapter extends Model
{
    /** @use HasFactory<ProjectChapterFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'paragraphs' => 'array',
            'sort_order' => 'integer',
            'translations' => 'array',
        ];
    }

    /**
     * The chapter title in the active locale, falling back to the Dutch title.
     */
    public function translatedTitle(): string
    {
        return $this->translations[app()->getLocale()]['title'] ?? $this->title;
    }

    /**
     * The chapter paragraphs in the active locale, falling back to the Dutch paragraphs.
     *
     * @return list<string>
     */
    public function translatedParagraphs(): array
    {
        return $this->translations[app()->getLocale()]['paragraphs'] ?? $this->paragraphs;
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
