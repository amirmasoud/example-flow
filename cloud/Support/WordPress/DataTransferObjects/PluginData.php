<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use Support\WordPress\Casts\ActiveInstallsCast;
use Support\WordPress\Casts\NumberFormatCast;
use Support\WordPress\Casts\RatingStarCast;

class PluginData extends DataTransferObject
{
    #[MapFrom('name')]
    public string $name;

    #[MapFrom('slug')]
    public string $slug;

    #[MapFrom('version')]
    public string $version;

    #[MapFrom('author')]
    public string $author;

    #[MapFrom('author_profile')]
    public string $author_profile;

    #[MapFrom('requires')]
    public string $requires;

    #[MapFrom('tested')]
    public string $tested;

    #[MapFrom('requires_php')]
    public string|bool $requires_php;

    #[MapFrom('rating')]
    #[CastWith(RatingStarCast::class)]
    public int $rating;

    #[MapFrom('num_ratings')]
    #[CastWith(NumberFormatCast::class)]
    public string $num_ratings;

    #[MapFrom('support_threads')]
    public int $support_threads;

    #[MapFrom('support_threads_resolved')]
    public int $support_threads_resolved;

    #[MapFrom('active_installs')]
    #[CastWith(ActiveInstallsCast::class)]
    public string $active_installs;

    #[MapFrom('downloaded')]
    public int $downloaded;

    #[MapFrom('last_updated')]
    public string $last_updated;

    #[MapFrom('added')]
    public string $added;

    #[MapFrom('homepage')]
    public string $homepage;

    #[MapFrom('short_description')]
    public string $short_description;

    #[MapFrom('description')]
    public string $description;

    #[MapFrom('download_link')]
    public string $download_link;

    #[MapFrom('donate_link')]
    public ?string $donate_link;

    #[MapFrom('icons')]
    public PluginIconsData $icons;
}
