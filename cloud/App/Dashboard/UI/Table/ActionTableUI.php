<?php

namespace App\Dashboard\UI\Table;

use JsonSerializable;

class ActionTableUI implements JsonSerializable
{
    public function __construct(public string $name, public string $label, public string $link)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label,
            'link' => $this->link,
        ];
    }
}
