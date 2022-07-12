<?php

namespace Domain\Sites\Enums;

enum DiskUnitEnum: string
{
    case MB = 'MB';
    case GB = 'GB';
    case TB = 'TB';

    public function label(): string
    {
        return match ($this) {
            self::MB => 'MegaBytes',
            self::GB => 'GigaBytes',
            self::TB => 'TeraBytes',
        };
    }
}
