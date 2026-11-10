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

    /**
     * Returns the light and dark Figma export of this group's icon. Icons without a dark variant reuse the light file.
     *
     * @return array{light: string, dark: string}
     */
    public function icon(): array
    {
        return match ($this) {
            self::Hardware => [
                'light' => 'images/icons/categories/light/hardware.svg',
                'dark' => 'images/icons/categories/light/hardware.svg',
            ],
            self::Software => [
                'light' => 'images/icons/categories/light/codeIcon.svg',
                'dark' => 'images/icons/categories/dark/CodeIcon.svg',
            ],
            self::Protocol => [
                'light' => 'images/icons/categories/light/protocol.svg',
                'dark' => 'images/icons/categories/light/protocol.svg',
            ],
            self::Sensor => [
                'light' => 'images/icons/categories/light/sensor.svg',
                'dark' => 'images/icons/categories/light/sensor.svg',
            ],
        };
    }
}
