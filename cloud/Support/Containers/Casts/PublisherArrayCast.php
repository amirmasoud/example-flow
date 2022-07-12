<?php

namespace Support\Containers\Casts;

use Exception;
use Spatie\DataTransferObject\Caster;
use Support\Containers\DataTransferObjects\PublisherData;

class PublisherArrayCast implements Caster
{
    /**
     * @throws Exception
     */
    public function cast(mixed $value): array
    {
        if (! is_array($value)) {
            throw new Exception('Can only cast arrays to Publisher');
        }

        return array_map(
            fn ($data) => new PublisherData(...collect($data)),
            $value
        );
    }
}
