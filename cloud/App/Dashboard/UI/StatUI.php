<?php

namespace App\Dashboard\UI;

class StatUI
{
    public function __construct(public string $name, public string $stat, public string $previousStat)
    {
        return [
            'name' => $this->name,
            'stat' => $this->stat,
            'previousStat' => $this->previousStat,
        ];
    }
}
