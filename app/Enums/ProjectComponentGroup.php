<?php

namespace App\Enums;

enum ProjectComponentGroup: string
{
    case Hardware = 'hardware';
    case Software = 'software';
    case Protocol = 'protocol';
    case Sensor = 'sensor';

    /**
     * Returns the translated heading for this group in the specifications list.
     */
    public function label(): string
    {
        return __('projects.components.'.$this->value);
    }
}
