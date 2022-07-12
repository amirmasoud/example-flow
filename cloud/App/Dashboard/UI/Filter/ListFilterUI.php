<?php

namespace App\Dashboard\UI\Filter;

class ListFilterUI
{
    public string $type = 'list';

    public function __construct(public string $name, public string $label, public array $items = [], public ?string $value = '')
    {
        return [
            'name'  => $this->name,
            'label' => $this->label,
            'value' => $this->value,
            'type'  => $this->type,
            'items' => $this->items,
        ];
    }
}
