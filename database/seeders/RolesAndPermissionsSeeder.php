<?php

namespace Database\Seeders;

use Domain\Users\Models\Role;
use Illuminate\Database\Seeder;
use Domain\Users\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign created permissions

        Role::create(['name' => 'writer'])
            ->givePermissionTo('edit articles');

        Role::create(['name' => 'moderator'])
            ->givePermissionTo(['publish articles', 'unpublish articles']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
    }
}
