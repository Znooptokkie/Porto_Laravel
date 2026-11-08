<?php

namespace App\Models;

use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $display_label
 * @property string|null $icon
 * @property int $proficiency
 * @property array<int, string>|null $subconcepts
 */
#[Fillable(['name', 'display_label', 'icon', 'proficiency', 'subconcepts'])]
class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
            'subconcepts' => 'array',
        ];
    }
}
