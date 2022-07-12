<?php

namespace Support\Containers\Casts;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class CarbonCaster implements Caster
{
    public function __construct(
        private array $types,
        private string $format
    ) {
    }

    public function cast(mixed $value): string|Carbon|null
    {
        if ($this->format) {
            return Carbon::createFromTimestamp($value)->format($this->format);
        }

        return Carbon::createFromTimestamp($value);
    }
}
