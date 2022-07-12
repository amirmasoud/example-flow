<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Support\WordPress\Casts\NumberFormatCast;
use Support\WordPress\Casts\RatingStarCast;

class ThemeData extends DataTransferObject
{
    #[MapFrom('name')]
    public string $name;

    #[MapFrom('slug')]
    public string $slug;

    #[MapFrom('version')]
    public string $version;

    #[MapFrom('preview_url')]
    public string $preview_url;

    #[MapFrom('screenshot_url')]
    public string $screenshot_url;

    #[MapFrom('rating')]
    #[CastWith(RatingStarCast::class)]
    public int $rating;

    #[MapFrom('num_ratings')]
    #[CastWith(NumberFormatCast::class)]
    public string $num_ratings;

    #[MapFrom('homepage')]
    public string $homepage;

    #[MapFrom('description')]
    public string $description;

    #[MapFrom('requires')]
    public string $requires;

    #[MapFrom('requires_php')]
    public string $requires_php;

    #[MapFrom('author')]
    public ThemeAuthorData $author;
}
