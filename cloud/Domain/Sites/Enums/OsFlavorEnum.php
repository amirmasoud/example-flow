<?php

namespace Domain\Sites\Enums;

enum OsFlavorEnum: string
{
    case ALPINE = 'alpine';
    case UBUNTU = 'ubuntu';
    case CENTOS = 'centos';
    case DEBIAN = 'debian';
    case WINDOWS = 'windows';

    public function label(): string
    {
        return match ($this) {
            self::ALPINE => 'Alpine',
            self::UBUNTU => 'Ubuntu',
            self::CENTOS => 'CentOS',
            self::DEBIAN => 'Debian',
            self::WINDOWS => 'Windows',
        };
    }
}
