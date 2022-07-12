<?php

namespace App\Dashboard\Resources\UI;

use App\Dashboard\UI\StatUI;
use Domain\Users\Models\User;

class UserStatResource extends BaseUI
{
    public function __construct(public User $user = new User)
    {
        parent::__construct($user);
    }

    public function toArray($request)
    {
        $total = User::count();

        return [
            new StatUI('Total Users', $total, $total),
            new StatUI('Verified Users', User::verified()->count(), $total),
            new StatUI('Unverified Users', User::unverified()->count(), $total),
        ];
    }
}
