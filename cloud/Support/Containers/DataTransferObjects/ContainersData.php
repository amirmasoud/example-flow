<?php

namespace Support\Containers\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Support\Containers\Casts\ContainerArrayCast;

class ContainersData extends DataTransferObject
{
    /** @var ContainerData[] */
    #[CastWith(ContainerArrayCast::class)]
    #[MapFrom('containers')]
    public array $containerData = [];
}
