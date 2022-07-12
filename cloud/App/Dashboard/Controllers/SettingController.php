<?php

namespace App\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Support\Containers\Enums\ContainerStateEnum;
use Support\Containers\ProcessContainer;
use Support\Containers\Shell\Docker;

class SettingController extends Controller
{
    public function general(): Response
    {
        return Inertia::render('Dashboard/Settings/General');
    }

    public function systemStatus(): Response
    {
        return Inertia::render('Dashboard/Settings/SystemStatus', [
            'docker_status' => Inertia::lazy(fn () => app(Docker::class)->isDockerServiceRunning()),
            'traefik_status' => Inertia::lazy(fn () => ProcessContainer::hasState('traefik', ContainerStateEnum::RUNNING)),
        ]);
    }
}
