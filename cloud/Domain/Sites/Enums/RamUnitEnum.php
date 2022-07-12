<?php

namespace Domain\Sites\Enums;

enum RamUnitEnum: string
{
    case MB = 'MB';
    case GB = 'GB';

    public function label(): string
    {
        return match ($this) {
            self::GB => 'MegaBytes',
            self::MB => 'GigaBytes',
        };
    }
}
