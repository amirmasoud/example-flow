<?php

namespace Domain\Sites\Policies;

use Domain\Users\Models\User;
use Domain\Sites\Models\Site;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Site $site)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->stacks()->count() && $user->servers()->count();
    }

    public function update(User $user, Site $site)
    {
        return true;
    }

    public function delete(User $user, Site $site)
    {
        return true;
    }

    public function restore(User $user, Site $site)
    {
        return true;
    }

    public function forceDelete(User $user, Site $site)
    {
        return true;
    }
}
