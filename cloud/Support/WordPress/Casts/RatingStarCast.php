<?php

namespace Support\WordPress\Casts;

use Exception;
use Spatie\DataTransferObject\Caster;

class RatingStarCast implements Caster
{
    /**
     * @throws Exception
     */
    public function cast(mixed $value): int
    {
        if (! is_numeric($value)) {
            throw new Exception('Can only cast numbers');
        }

        return floor($value / 20);
    }
}
