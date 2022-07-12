<?php

namespace App\Dashboard\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Domain\Users\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Dashboard\Requests\PermissionRequest;
use App\Dashboard\Resources\PermissionResource;
use App\Dashboard\Requests\PermissionSearchRequest;
use App\Dashboard\Resources\UI\PermissionTableResource;
use App\Dashboard\Resources\UI\PermissionFilterResource;

class PermissionController extends Controller
{
    public function index(PermissionSearchRequest $request): Response
    {
        $permissions = Permission::search($request->validated('search'))->paginate($request->validated('per_page'))->withQueryString();

        return Inertia::render('Dashboard/Users/Permissions/Index', [
            'records' => PermissionResource::collection($permissions),
            'filters' => fn () => new PermissionFilterResource(),
            'table' => fn () => new PermissionTableResource(),
        ]);
    }

    public function store(PermissionRequest $request): RedirectResponse
    {
        Permission::create($request->validated());

        return redirect()->to('/dashboard/users/permissions');
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Users/Permissions/Create');
    }

    public function edit(Permission $permission): Response
    {
        return Inertia::render('Dashboard/Users/Permissions/Edit', [
            'resource' => new PermissionResource($permission),
        ]);
    }

    public function update(Permission $permission, PermissionRequest $request): RedirectResponse
    {
        $permission->update($request->validated());

        return redirect()->to('/dashboard/users/permissions');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $permission->delete();

        return redirect()->back();
    }
}
