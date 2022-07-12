<?php

namespace Support\Containers\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class PublisherData extends DataTransferObject
{
    #[MapFrom('URL')]
    public ?string $url;

    #[MapFrom('TargetPort')]
    public ?int $targetPort;

    #[MapFrom('PublishedPort')]
    public ?int $publishedPort;

    #[MapFrom('Protocol')]
    public ?string $protocol;
}
