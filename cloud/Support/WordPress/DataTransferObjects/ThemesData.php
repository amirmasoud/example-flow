<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Support\WordPress\Casts\ThemeArrayCaster;

class ThemesData extends DataTransferObject
{
    /** @var ThemeData[] */
    #[MapFrom('themes')]
    #[CastWith(ThemeArrayCaster::class)]
    public array $themes;
}
