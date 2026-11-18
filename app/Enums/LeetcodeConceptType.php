<?php

namespace App\Enums;

enum LeetcodeConceptType: string
{
    case Function = 'function';
    case Method = 'method';
    case Operator = 'operator';
    case DataStructure = 'data_structure';
    case ControlStructure = 'control_structure';
    case Algorithm = 'algorithm';

    /**
     * The translation key of the group heading on the problem card, e.g. `leetcode.card.functions`.
     */
    public function translationKey(): string
    {
        return match ($this) {
            self::Function => 'functions',
            self::Method => 'methods',
            self::Operator => 'operators',
            self::DataStructure => 'data_structures',
            self::ControlStructure => 'control_structures',
            self::Algorithm => 'algorithms',
        };
    }
}
