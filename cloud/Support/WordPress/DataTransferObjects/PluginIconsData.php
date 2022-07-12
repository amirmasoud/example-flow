<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class PluginIconsData extends DataTransferObject
{
    #[MapFrom('1x')]
    public ?string $icon_1x;

    #[MapFrom('2x')]
    public ?string $icon_2x;

    #[MapFrom('svg')]
    public ?string $icon_svg;
}
