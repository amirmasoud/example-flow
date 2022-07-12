<?php

namespace App\Dashboard\Resources\UI;

use App\Dashboard\UI\Filter\InputFilterUI;
use App\Dashboard\UI\Filter\ListFilterUI;
use Domain\Sites\Models\Server;

class ServerFilterResource extends BaseUI
{
    public function __construct(public Server $server = new Server)
    {
        parent::__construct($server);
    }

    public function toArray($request)
    {
        return [
            new InputFilterUI('search', 'Search', $request->input('search')),
            new ListFilterUI('per_page', 'Per page', ['10' => 10, '25' => 25, '50' => 50, '100' => 100], $request->input('per_page') ?? 25),
        ];
    }
}
