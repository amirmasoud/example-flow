<?php

namespace Domain\Users\Enums;

enum LocaleEnum: string
{
    case EN_US = 'english_us';

    public function label(): string
    {
        return match ($this) {
            self::EN_US => 'English (US)',
        };
    }
}
