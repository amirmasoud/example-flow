<?php

namespace App\Dashboard\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Domain\Users\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Dashboard\Requests\RoleRequest;
use App\Dashboard\Resources\RoleResource;
use App\Dashboard\Requests\RoleSearchRequest;
use App\Dashboard\Resources\UI\RoleFilterResouce;
use App\Dashboard\Resources\UI\RoleTableResource;

class RoleController extends Controller
{
    public function index(RoleSearchRequest $request): Response
    {
        $roles = Role::search($request->validated('search'))->paginate($request->validated('per_page'))->withQueryString();

        return Inertia::render('Dashboard/Users/Roles/Index', [
            'records' => RoleResource::collection($roles),
            'filters' => fn () => new RoleFilterResouce(),
            'table' => fn () => new RoleTableResource(),
        ]);
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return redirect()->to('/dashboard/users/roles');
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Users/Roles/Create');
    }

    public function edit(Role $role): Response
    {
        return Inertia::render('Dashboard/Users/Roles/Edit', [
            'resource' => new RoleResource($role),
        ]);
    }

    public function update(Role $role, RoleRequest $request): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()->to('/dashboard/users/roles');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->back();
    }
}
