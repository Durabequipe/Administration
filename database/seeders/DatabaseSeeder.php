<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $this->call(PermissionsSeeder::class);

        User::find(1)->assignRole('super-admin');
        User::find(2)->assignRole('user');

        $this->call(InteractionSeeder::class);
        /*$this->call(InteractionSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(VideoSeeder::class);*/
    }
}
