<?php

namespace App\Dashboard\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Domain\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Dashboard\Requests\UserRequest;
use App\Dashboard\Resources\UserResource;
use App\Dashboard\Requests\UserSearchRequest;
use App\Dashboard\Resources\UI\UserStatResource;
use App\Dashboard\Resources\UI\UserTableResource;
use App\Dashboard\Resources\UI\UserFilterResource;

class UserController extends Controller
{
    public function index(UserSearchRequest $request): Response
    {
        $users = User::search($request->validated('search'))->paginate($request->validated('per_page'))->withQueryString();

        return Inertia::render('Dashboard/Users/Index', [
            'records' => UserResource::collection($users),
            'filters' => fn () => new UserFilterResource(),
            'stats' => fn () => new UserStatResource(),
            'table' => fn () => new UserTableResource(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->to('/dashboard/users');
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Users/Create');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Dashboard/Users/Edit', [
            'resource' => new UserResource($user),
        ]);
    }

    public function update(User $user, UserRequest $request): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->to('/dashboard/users');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->back();
    }
}
