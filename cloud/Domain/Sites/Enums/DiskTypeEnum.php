<?php

namespace Domain\Sites\Enums;

enum DiskTypeEnum: string
{
    case SSD = 'SSD';
    case HDD = 'HDD';

    public function label(): string
    {
        return match ($this) {
            self::SSD => 'SSD',
            self::HDD => 'HDD',
        };
    }
}
