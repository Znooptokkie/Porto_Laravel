<?php

namespace App\Models;

use Database\Factories\LinuxCommandFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $category
 * @property string|null $card_title
 * @property string|null $card_title_en
 * @property string|null $keyword
 * @property string $command
 * @property string $description
 * @property string|null $description_en
 * @property int $position
 */
#[Fillable(['category', 'card_title', 'card_title_en', 'keyword', 'command', 'description', 'description_en', 'position'])]
class LinuxCommand extends Model
{
    /** @use HasFactory<LinuxCommandFactory> */
    use HasFactory;

    /**
     * The card title in the current language. The English title is used when the locale is English and one is stored.
     */
    public function localizedCardTitle(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->card_title_en) ? $this->card_title_en : $this->card_title;
    }

    /**
     * The description in the current language. The English description is used when the locale is English and one is stored.
     */
    public function localizedDescription(): string
    {
        return app()->getLocale() === 'en' && filled($this->description_en) ? $this->description_en : $this->description;
    }
}
