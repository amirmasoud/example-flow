<?php

namespace Domain\Sites\DataTransferObjects\WordPress;

use Spatie\DataTransferObject\DataTransferObject;

class WordPressServiceStackPropertiesData extends DataTransferObject
{
    public string $php = '8.0';

    public string $database = 'mariadb';

    public string $database_version = 'latest';

    public string $reverse_proxy = 'nginx';

    public string $reverse_proxy_version = 'latest';
}
