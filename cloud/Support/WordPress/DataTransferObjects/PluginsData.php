<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Support\WordPress\Casts\PluginArrayCaster;

class PluginsData extends DataTransferObject
{
    /** @var PluginData[] */
    #[MapFrom('plugins')]
    #[CastWith(PluginArrayCaster::class)]
    public array $plugins;
}
