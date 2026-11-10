<?php

namespace App\Models;

use App\Enums\ProjectComponentGroup;
use Database\Factories\ProjectComponentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $project_id
 * @property ProjectComponentGroup $group
 * @property string $name
 * @property int $sort_order
 */
#[Fillable(['project_id', 'group', 'name', 'sort_order'])]
class ProjectComponent extends Model
{
    /** @use HasFactory<ProjectComponentFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'group' => ProjectComponentGroup::class,
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
