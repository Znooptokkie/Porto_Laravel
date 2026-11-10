<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Klaar = 'klaar';
    case InConstructie = 'in_constructie';
    case Onvoltooid = 'onvoltooid';

    /**
     * Returns the translated badge label shown on project cards and detail pages.
     */
    public function label(): string
    {
        return __('projects.status.'.$this->value);
    }
}
