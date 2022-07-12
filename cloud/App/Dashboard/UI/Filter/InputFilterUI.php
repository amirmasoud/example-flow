<?php

namespace App\Dashboard\UI\Filter;

class InputFilterUI
{
    public string $type = 'input';

    public function __construct(public string $name, public string $label, public ?string $value = '')
    {
        return [
            'name'  => $this->name,
            'label' => $this->label,
            'value' => $this->value,
            'type'  => $this->type,
        ];
    }
}
