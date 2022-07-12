<?php

namespace Support\WordPress\Casts;

use Exception;
use Spatie\DataTransferObject\Caster;

class ActiveInstallsCast implements Caster
{
    /**
     * @throws Exception
     */
    public function cast(mixed $value): string
    {
        if (! is_numeric($value)) {
            throw new Exception('Can only cast numbers');
        }

        return $value >= 1000000
            ? round($value / 1000000).'+ million active installations'
            : number_format(round('.'.$value, 1) * 10 .str_repeat(0, strlen($value) - 1)).'+ active installations';
    }
}
