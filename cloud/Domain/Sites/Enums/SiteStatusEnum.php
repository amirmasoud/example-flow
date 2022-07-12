<?php

namespace Domain\Sites\Enums;

enum SiteStatusEnum: string
{
    case UP = 'up';
    case INSTALLING = 'installing';
    case RETRYING = 'retrying';
    case FAILED = 'failed';
    case STARTING = 'starting';
    case STOPPING = 'stopping';
    case STOPPED = 'stopped';
    case RESTARTING = 'restarting';
    case DELETING = 'deleting';

    public function label(): string
    {
        return match ($this) {
            self::UP => 'Up',
            self::INSTALLING => 'Installing',
            self::RETRYING => 'Retrying',
            self::FAILED => 'Failed',
            self::STARTING => 'Starting',
            self::STOPPING => 'Stopping',
            self::STOPPED => 'Stopped',
            self::RESTARTING => 'Restarting',
            self::DELETING => 'Deleting',
        };
    }
}
