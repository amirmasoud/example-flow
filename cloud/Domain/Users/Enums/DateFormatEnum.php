<?php

namespace Domain\Users\Enums;

enum DateFormatEnum: string
{
    case YYYY_MM_DD = 'y/m/d';

    public function label(): string
    {
        return match ($this) {
            self::YYYY_MM_DD => 'YYYY-MM-DD ('.date(self::YYYY_MM_DD->value).')',
        };
    }
}
