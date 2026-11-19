<?php

namespace App\Models;

use Database\Factories\ShellScriptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property string|null $title_en
 * @property string|null $description
 * @property string|null $description_en
 * @property string|null $package
 * @property string|null $install_command
 * @property string|null $install_command_debian
 * @property string $code
 */
#[Fillable(['name', 'title', 'title_en', 'description', 'description_en', 'package', 'install_command', 'install_command_debian', 'code'])]
class ShellScript extends Model
{
    /** @use HasFactory<ShellScriptFactory> */
    use HasFactory;

    /**
     * The title in the current language. The English title is used when the locale is English and one is stored.
     */
    public function localizedTitle(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->title_en) ? $this->title_en : $this->title;
    }

    /**
     * The description in the current language. The English description is used when the locale is English and one is stored.
     */
    public function localizedDescription(): ?string
    {
        return app()->getLocale() === 'en' && filled($this->description_en) ? $this->description_en : $this->description;
    }
}
