<?php

namespace App\Models;

use Database\Factories\ContributorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property string $name
 * @property string|null $url
 */
#[Fillable(['name', 'url'])]
class Contributor extends Model
{
    /** @use HasFactory<ContributorFactory> */
    use HasFactory;

    /**
     * Projects this contributor worked on. One contributor can be linked to several projects.
     *
     * @return BelongsToMany<Project, $this, Pivot>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_contributor')->withPivot(['role', 'sort_order']);
    }
}
