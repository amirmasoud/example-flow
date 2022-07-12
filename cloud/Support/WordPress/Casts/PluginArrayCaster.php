<?php

namespace Support\WordPress\Casts;

use Exception;
use Spatie\DataTransferObject\Caster;
use Support\WordPress\DataTransferObjects\PluginData;

class PluginArrayCaster implements Caster
{
    /**
     * @throws Exception
     */
    public function cast(mixed $value): array
    {
        if (! is_array($value)) {
            throw new Exception('Can only cast arrays to Plugin');
        }

        return array_map(
            fn (array $data) => new PluginData(...$data),
            $value
        );
    }
}
