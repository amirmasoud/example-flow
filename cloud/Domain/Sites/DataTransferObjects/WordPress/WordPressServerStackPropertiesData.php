<?php

namespace Domain\Sites\DataTransferObjects\WordPress;

use Spatie\DataTransferObject\DataTransferObject;

class WordPressServerStackPropertiesData extends DataTransferObject
{
    public string $price = 'Free';

    public int $ram;

    public string $ram_unit = 'GB';

    public int $cpu;

    public string $disk;

    public string $disk_unit = 'GB';

    public string $disk_type = 'SSD';
}
