<?php

namespace App\Dashboard\Controllers;

use App\Dashboard\Requests\ServerRequest;
use App\Dashboard\Resources\ServerResource;
use App\Dashboard\Resources\UI\ServerFilterResource;
use App\Dashboard\Resources\UI\ServerTableResource;
use App\Http\Controllers\Controller;
use Domain\Sites\Enums\DiskTypeEnum;
use Domain\Sites\Enums\DiskUnitEnum;
use Domain\Sites\Enums\OsFlavorEnum;
use Domain\Sites\Enums\RamUnitEnum;
use Domain\Sites\Enums\ServerStatusEnum;
use Domain\Sites\Models\Server;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ServerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Sites/Servers/Index', [
            'records' => ServerResource::collection(Server::paginate()->withQueryString()),
            'table' => fn () => new ServerTableResource(),
            'filters' => fn () => new ServerFilterResource(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Sites/Servers/Create', [
            'ramUnits' => array_map(fn (RamUnitEnum $ramUnit) => ['label' => $ramUnit->label(), 'value' => $ramUnit->value], RamUnitEnum::cases()),
            'diskTypes' => array_map(fn (DiskTypeEnum $diskType) => ['label' => $diskType->label(), 'value' => $diskType->value], DiskTypeEnum::cases()),
            'diskUnits' => array_map(fn (DiskUnitEnum $diskUnit) => ['label' => $diskUnit->label(), 'value' => $diskUnit->value], DiskUnitEnum::cases()),
            'osFlavors' => array_map(fn (OsFlavorEnum $osFlavor) => ['label' => $osFlavor->label(), 'value' => $osFlavor->value], OsFlavorEnum::cases()),
            'serverStatuses' => array_map(fn (ServerStatusEnum $serverStatus) => ['label' => $serverStatus->label(), 'value' => $serverStatus->value], ServerStatusEnum::cases()),
        ]);
    }

    public function store(ServerRequest $request): RedirectResponse
    {
        Auth::user()->servers()->create($request->validated());

        return redirect()->route('dashboard.sites.servers.index');
    }

    public function edit(Server $server): Response
    {
        return Inertia::render('Dashboard/Sites/Servers/Edit', [
            'resource' => new ServerResource($server),
            'ramUnits' => array_map(fn (RamUnitEnum $ramUnit) => ['label' => $ramUnit->label(), 'value' => $ramUnit->value], RamUnitEnum::cases()),
            'diskTypes' => array_map(fn (DiskTypeEnum $diskType) => ['label' => $diskType->label(), 'value' => $diskType->value], DiskTypeEnum::cases()),
            'diskUnits' => array_map(fn (DiskUnitEnum $diskUnit) => ['label' => $diskUnit->label(), 'value' => $diskUnit->value], DiskUnitEnum::cases()),
            'osFlavors' => array_map(fn (OsFlavorEnum $osFlavor) => ['label' => $osFlavor->label(), 'value' => $osFlavor->value], OsFlavorEnum::cases()),
            'serverStatuses' => array_map(fn (ServerStatusEnum $serverStatus) => ['label' => $serverStatus->label(), 'value' => $serverStatus->value], ServerStatusEnum::cases()),
        ]);
    }

    public function update(Server $server, ServerRequest $request): RedirectResponse
    {
        $server->update($request->validated());

        return redirect()->route('dashboard.sites.servers.index');
    }

    public function destroy(Server $server): RedirectResponse
    {
        $server->delete();

        return redirect()->back();
    }
}
