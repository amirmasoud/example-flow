<?php

namespace App\Providers;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\Stack;
use Domain\Sites\Policies\SitePolicy;
use Domain\Sites\Policies\StackPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Stack::class => StackPolicy::class,
        Site::class => SitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
