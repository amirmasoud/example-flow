<?php

namespace Support\Containers\Casts;

use Exception;
use Spatie\DataTransferObject\Caster;
use Support\Containers\DataTransferObjects\ContainerData;

class ContainerArrayCast implements Caster
{
    /**
     * @throws Exception
     */
    public function cast(mixed $value): array
    {
        if (! is_array($value)) {
            throw new Exception('Can only cast arrays to Container');
        }

        return array_map(
            fn ($data) => new ContainerData(...collect($data)),
            $value
        );
    }
}
