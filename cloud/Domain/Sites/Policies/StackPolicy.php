<?php

namespace Domain\Sites\Policies;

use Domain\Users\Models\User;
use Domain\Sites\Models\Stack;
use Illuminate\Auth\Access\HandlesAuthorization;

class StackPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Stack $stack)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Stack $stack)
    {
        return true;
    }

    public function delete(User $user, Stack $stack)
    {
        return ! $stack->sites()->exists();
    }

    public function restore(User $user, Stack $stack)
    {
        return true;
    }

    public function forceDelete(User $user, Stack $stack)
    {
        return true;
    }
}
