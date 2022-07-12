<?php

namespace App\Dashboard\Controllers;

use App\Dashboard\Requests\StackRequest;
use App\Dashboard\Resources\StackResource;
use App\Dashboard\Resources\UI\StackFilterResource;
use App\Dashboard\Resources\UI\StackTableResource;
use App\Http\Controllers\Controller;
use Domain\Sites\Enums\StackTypeEnum;
use Domain\Sites\Models\Stack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Support\WordPress\ApiWordPress;

class StackController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Stack::class, 'stack');
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard/Sites/Stacks/Index', [
            'records' => StackResource::collection(Stack::paginate()->withQueryString()),
            'table' => fn () => new StackTableResource(),
            'filters' => fn () => new StackFilterResource(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Sites/Stacks/New', [
            'plugins' => fn () => ApiWordPress::plugins(),
            'themes' => fn () => ApiWordPress::themes(),
            'types' => array_map(fn (StackTypeEnum $stack) => ['value' => $stack->value, 'label' => $stack->label(), 'icon' => $stack->icon()], StackTypeEnum::cases()), // @todo refactor to resources
        ]);
    }

    public function store(StackRequest $request): RedirectResponse
    {
        Auth::user()->stacks()->create($request->validated());

        return redirect()->route('dashboard.sites.stacks.index');
    }

    public function edit(Stack $stack): Response
    {
        return Inertia::render('Dashboard/Sites/Stacks/Edit', [
            'resource' => new StackResource($stack),
            'plugins' => fn () => ApiWordPress::plugins(),
            'themes' => fn () => ApiWordPress::themes(),
            'types' => array_map(fn (StackTypeEnum $stack) => ['value' => $stack->value, 'label' => $stack->label(), 'icon' => $stack->icon()], StackTypeEnum::cases()), // @todo refactor to resources
        ]);
    }

    public function update(Stack $stack, StackRequest $request): RedirectResponse
    {
        $stack->update($request->validated());

        return redirect()->route('dashboard.sites.stacks.index');
    }

    public function destroy(Stack $stack): RedirectResponse
    {
        $stack->delete();

        return redirect()->back();
    }
}
