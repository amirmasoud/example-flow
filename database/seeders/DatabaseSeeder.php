<?php

namespace Database\Seeders;

use Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (! User::whereEmail('admin@cloud.test')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@cloud.test',
                'password' => bcrypt('secret'),
            ]);
        }

        User::factory(100)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
