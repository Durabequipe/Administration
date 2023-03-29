<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Video;
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
        $user = User::find(2);
        $user->assignRole('user');

        $this->call(ProjectSeeder::class);
        $this->call(VideoSeeder::class);

        $project = Project::first();
        $project->users()->attach($user);
        $project->videos()->saveMany(Video::all());

        Video::first()->adjacents()->attach(Video::all()->last(), ['content' => 'test']);


        $this->call(InteractionSeeder::class);
        /*$this->call(InteractionSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(VideoSeeder::class);*/
    }
}
