<?php

namespace Support\WordPress\DataTransferObjects;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class ThemeAuthorData extends DataTransferObject
{
    #[MapFrom('user_nicename')]
    public string $user_nicename;

    #[MapFrom('profile')]
    public string $profile;

    #[MapFrom('avatar')]
    public string $avatar;

    #[MapFrom('display_name')]
    public string $display_name;

    #[MapFrom('author')]
    public string $author;

    #[MapFrom('author_url')]
    public string $author_url;
}
