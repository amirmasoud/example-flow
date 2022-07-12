<?php

namespace Domain\Sites\Enums;

enum StackTypeEnum: string
{
    case WORDPRESS = 'wordpress';

    public function label(): string
    {
        return match ($this) {
            self::WORDPRESS => 'WordPress',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::WORDPRESS => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1024px-WordPress_blue_logo.svg.png',
        };
    }
}
