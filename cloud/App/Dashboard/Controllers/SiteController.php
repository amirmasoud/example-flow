<?php

namespace App\Dashboard\Controllers;

use App\Dashboard\Requests\SiteRequest;
use App\Dashboard\Requests\SiteSearchRequest;
use App\Dashboard\Resources\ServerResource;
use App\Dashboard\Resources\SiteResource;
use App\Dashboard\Resources\StackResource;
use App\Dashboard\Resources\UI\SiteFilterResource;
use App\Dashboard\Resources\UI\SiteStatResource;
use App\Dashboard\Resources\UI\SiteTableResource;
use App\Http\Controllers\Controller;
use Domain\Sites\Enums\SiteStatusEnum;
use Domain\Sites\Enums\StackTypeEnum;
use Domain\Sites\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Support\Containers\ProcessContainer;
use Support\Containers\Shell\DockerCompose;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Site::class, 'site');
    }

    public function index(SiteSearchRequest $request): Response
    {
        $sites = Site::withTrashed()->search($request->validated('search'))->paginate($request->input('per_page'))->withQueryString();

        return Inertia::render('Dashboard/Sites/Index', [
            'records' => SiteResource::collection($sites),
            'filters' => fn () => new SiteFilterResource(),
            'stats' => fn () => new SiteStatResource(),
            'table' => fn () => new SiteTableResource(),
            'canCreate' => auth()->user()->stacks()->count() && auth()->user()->servers()->count(),
            'status' => fn () => DockerCompose::for($sites->first()->host)->status(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Sites/Create', [
            'servers' => ServerResource::collection(Auth::user()->servers()->get()),
            'stacks' => StackResource::collection(Auth::user()->stacks()->get()),
            'types' => array_map(fn (StackTypeEnum $stack) => ['value' => $stack->value, 'label' => $stack->label(), 'icon' => $stack->icon()], StackTypeEnum::cases()), // @todo refactor to resources
        ]);
    }

    public function store(SiteRequest $request): RedirectResponse
    {
        Auth::user()->sites()->create(
            array_merge(
                $request->validated(),
                ['status' => SiteStatusEnum::INSTALLING]
            )
        );

        return redirect()->to('/dashboard/sites');
    }

    public function show(Site $site): Response
    {
        return Inertia::render('Dashboard/Sites/Show', [
            'record' => new SiteResource($site),
            'wordpress' => fn () => ProcessContainer::details("$site->name-wordpress"),
            'database' => fn () => ProcessContainer::details("$site->name-database"),
            'state' => fn () => ProcessContainer::state("$site->name-wordpress"),
        ]);
    }

    public function edit(Site $site): Response
    {
        return Inertia::render('Dashboard/Sites/Edit', [
            'resource' => new SiteResource($site),
        ]);
    }

    public function update(Site $site, SiteRequest $request): RedirectResponse
    {
        $site->update($request->validated());

        return redirect()->to('/dashboard/sites');
    }

    public function destroy(Site $site): RedirectResponse
    {
        $site->delete();

        return redirect()->back();
    }

    public function forceDestroy(int $site): RedirectResponse
    {
        Site::withTrashed()->findOrFail($site)->forceDelete();

        return redirect()->back();
    }

    public function restore(int $site): RedirectResponse
    {
        Site::withTrashed()->findOrFail($site)->restore();

        return redirect()->back();
    }

    public function cli(Site $site, ?string $command = null)
    {
        return Inertia::render('Dashboard/Sites/Cli', [
            'record' => new SiteResource($site),
            'output' => ProcessContainer::for($site)->exec($command ?? 'wordpress-cli wp --info'),
        ]);
    }

    public function start(Site $site): RedirectResponse
    {
        event('eloquent.started: '.Site::class, $site);

        return redirect()->back();
    }

    public function stop(Site $site): RedirectResponse
    {
        event('eloquent.stopped: '.Site::class, $site);

        return redirect()->back();
    }

    public function restart(Site $site): RedirectResponse
    {
        event('eloquent.restarted: '.Site::class, $site);

        return redirect()->back();
    }
}
