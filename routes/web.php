<?php

use Inertia\Inertia;
use Domain\Sites\Models\Site;
use App\Dashboard\Controllers\RoleController;
use App\Dashboard\Controllers\SiteController;
use App\Dashboard\Controllers\UserController;
use App\Dashboard\Controllers\OauthController;
use App\Dashboard\Controllers\StackController;
use App\Dashboard\Controllers\ServerController;
use App\Dashboard\Controllers\SettingController;
use Support\Containers\Enums\ContainerStateEnum;
use App\Dashboard\Controllers\PermissionController;

Route::middleware('guest')->group(function () {
    Route::get('login', [OauthController::class, 'loginForm'])->name('login');
    Route::post('login', [OauthController::class, 'loginWithEmail']);
    Route::get('register', [OauthController::class, 'registerWithEmailForm'])->name('register');
    Route::post('register', [OauthController::class, 'registerWithEmail']);
    Route::get('auth/{provider}/callback', [OauthController::class, 'callback']);
});
Route::post('logout', [OauthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard/Home', [
            'stats' => [
                ['name' => 'Total Sites', 'stat' => Site::count(), 'previousStat' => '70,946'],
                ['name' => 'Running Sites', 'stat' => Site::whereStatus(ContainerStateEnum::STARTED)->count(), 'previousStat' => '56.14%'],
                ['name' => 'Stopped Sites', 'stat' => Site::whereStatus(ContainerStateEnum::STOPPED)->count(), 'previousStat' => '28.62%'],
            ],
        ]);
    })->name('index');

    Route::get('/settings', [SettingController::class, 'general'])->name('settings.general');
    Route::get('/settings/system-status', [SettingController::class, 'systemStatus'])->name('settings.system-status');

    Route::resource('users', UserController::class)->except('show');
    Route::name('users.')
        ->prefix('users')
        ->group(function () {
            Route::resource('roles', RoleController::class)->except('show');
            Route::resource('permissions', PermissionController::class)->except('show');
        });

    Route::controller(SiteController::class)
        ->name('sites.')
        ->prefix('sites')
        ->group(function () {
            Route::resource('servers', ServerController::class);
            Route::resource('stacks', StackController::class);

            Route::get('{site}/cli/{command?}', 'cli');
            Route::post('{site}/start', 'start');
            Route::post('{site}/stop', 'stop');
            Route::post('{site}/restart', 'restart');
        });
    Route::resource('sites', SiteController::class);
    Route::delete('sites/{site}/force-delete', [SiteController::class, 'forceDestroy'])->name('sites.force-destroy');
    Route::post('sites/{site}/restore', [SiteController::class, 'restore'])->name('sites.restore');

    Route::controller(StackController::class)->group(function () {
        Route::get('stacks/wordpress/new', 'newWordPressSite')->name('slacks.wordpress.new');
        Route::get('stacks/plugins', 'plugins')->name('slacks.plugins');
        Route::get('stacks/themes', 'themes')->name('slacks.themes');
        Route::get('stacks/plans', 'plans')->name('slacks.plans');
    });
});
