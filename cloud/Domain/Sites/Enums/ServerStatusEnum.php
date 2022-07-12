<?php

namespace Domain\Sites\Enums;

enum ServerStatusEnum: string
{
    case IDLE = 'idle';
    case OFFLINE = 'offline';
    case ONLINE = 'online';
    case ERROR = 'error';
    case UNREACHABLE = 'unreachable';

    public function label(): string
    {
        return match ($this) {
            self::IDLE => 'Idle',
            self::OFFLINE => 'Offline',
            self::ONLINE => 'Online',
            self::ERROR => 'Error',
            self::UNREACHABLE => 'Unreachable',
        };
    }
}
