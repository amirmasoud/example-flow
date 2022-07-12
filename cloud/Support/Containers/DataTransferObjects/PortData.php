<?php

namespace Support\Containers\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class PortData extends DataTransferObject
{
    #[MapFrom('PrivatePort')]
    public string $port;

    #[MapFrom('Type')]
    public string $type;
}
