<?php

namespace App\Dashboard\UI\Table;

use JsonSerializable;

class FieldTableUI implements JsonSerializable
{
    public function __construct(public string $name, public string $label)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'name'  => $this->name,
            'label' => $this->label,
        ];
    }
}
