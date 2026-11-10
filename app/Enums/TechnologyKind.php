<?php

namespace App\Enums;

enum TechnologyKind: string
{
    case Language = 'language';
    case Framework = 'framework';
    case Other = 'other';
}
