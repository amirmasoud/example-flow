<?php

namespace Support\Containers\Enums;

enum CertificateEnum: string
{
    // For testing purposes only
    case SELF_SIGNED = 'self_signed';

    public function label(): string
    {
        return match ($this) {
            self::SELF_SIGNED => 'Self Signed',
        };
    }
}
