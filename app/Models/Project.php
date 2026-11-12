<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\HtmlString;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $title_accent
 * @property string $category
 * @property string|null $intro_label
 * @property int $started_year
 * @property int|null $ended_year
 * @property string $summary
 * @property string|null $subtitle
 * @property string|null $story_lead
 * @property string|null $media_tagline
 * @property string|null $story_heading
 * @property string|null $story_heading_accent
 * @property string|null $story_aside
 * @property ProjectStatus $status
 * @property int|null $favorite_rank
 * @property string|null $organization
 * @property string|null $department
 * @property string|null $repository_url
 * @property int $sort_order
 * @property array<string, array<string, string>>|null $translations
 */
#[Fillable(['slug', 'title', 'title_accent', 'category', 'intro_label', 'started_year', 'ended_year', 'summary', 'subtitle', 'story_lead', 'media_tagline', 'story_heading', 'story_heading_accent', 'story_aside', 'status', 'favorite_rank', 'organization', 'department', 'repository_url', 'sort_order', 'translations'])]
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'favorite_rank' => 'integer',
            'started_year' => 'integer',
            'ended_year' => 'integer',
            'sort_order' => 'integer',
            'translations' => 'array',
        ];
    }

    /**
     * Returns the stored value of an attribute in the active locale, or the Dutch original when no translation exists.
     */
    public function translated(string $attribute): string
    {
        return $this->translations[app()->getLocale()][$attribute] ?? (string) ($this->{$attribute} ?? '');
    }

    /**
     * The translated text as escaped HTML, with every part between asterisks wrapped in a strong element that is bold and takes the accent colour ("sensoren en *N-Mosfets*").
     */
    public function accented(string $attribute): HtmlString
    {
        $escaped = e($this->translated($attribute));

        return new HtmlString(preg_replace('/\*(.+?)\*/', '<strong>$1</strong>', $escaped) ?? $escaped);
    }

    /**
     * The part of the title before the accent, shown in the text colour on the detail page ("Battle" for "Battlebot").
     */
    public function titleLead(): string
    {
        $title = $this->translated('title');

        if ($this->title_accent === null || ! str_ends_with($title, $this->title_accent)) {
            return $title;
        }

        return substr($title, 0, -strlen($this->title_accent));
    }

    /**
     * The specification components grouped by their group value, for example "hardware".
     *
     * @return SupportCollection<int|string, Collection<int, ProjectComponent>>
     */
    public function componentGroups(): SupportCollection
    {
        return collect($this->components->groupBy(fn (ProjectComponent $component): string => $component->group->value)->all());
    }

    /**
     * The period shown next to the category, for example "2024 | 2025" or "2026".
     */
    public function periodLabel(): string
    {
        return collect([$this->started_year, $this->ended_year])
            ->filter()
            ->implode(' | ');
    }

    /**
     * A project is a favourite when it has a rank; rank 1 is the most favourite.
     */
    public function isFavorite(): bool
    {
        return $this->favorite_rank !== null;
    }

    /**
     * @return HasMany<ProjectImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ProjectChapter, $this>
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(ProjectChapter::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ProjectLink, $this>
     */
    public function links(): HasMany
    {
        return $this->hasMany(ProjectLink::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ProjectComponent, $this>
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProjectComponent::class)->orderBy('sort_order');
    }

    /**
     * @return BelongsToMany<Contributor, $this, Pivot>
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(Contributor::class, 'project_contributor')
            ->withPivot(['role', 'sort_order'])
            ->orderByPivot('sort_order');
    }

    /**
     * All technologies linked to the project, for every placement (card and detail).
     *
     * @return BelongsToMany<Technology, $this, Pivot>
     */
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class)->withPivot(['placement', 'sort_order']);
    }

    /**
     * Technologies shown as chips on the overview card; also used by the language and framework filters.
     *
     * @return BelongsToMany<Technology, $this, Pivot>
     */
    public function cardTechnologies(): BelongsToMany
    {
        return $this->technologiesWithPlacement('card');
    }

    /**
     * Technologies shown as chips on the project detail page.
     *
     * @return BelongsToMany<Technology, $this, Pivot>
     */
    public function detailTechnologies(): BelongsToMany
    {
        return $this->technologiesWithPlacement('detail');
    }

    /**
     * @return BelongsToMany<ProjectType, $this, Pivot>
     */
    public function projectTypes(): BelongsToMany
    {
        return $this->belongsToMany(ProjectType::class)->orderBy('name');
    }

    /**
     * @return BelongsToMany<Technology, $this, Pivot>
     */
    private function technologiesWithPlacement(string $placement): BelongsToMany
    {
        return $this->belongsToMany(Technology::class)
            ->withPivot(['placement', 'sort_order'])
            ->wherePivot('placement', $placement)
            ->orderByPivot('sort_order');
    }
}
