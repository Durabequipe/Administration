<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public function test_cannot_fetch_players_without_api_key(): void
    {
        $response = $this->getJson(route('api.players.index'));

        $response->assertStatus(401);
    }

    public function test_can_fetch_players_with_api_key()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $project->users()->attach($user);

        $response = $this->getJson(route('api.players.index'), [
            'x-api-key' => $user->api_key
        ]);

        $response->assertOk();

        $response->assertSee($project->name);
    }

    public function test_can_show_players_with_api_key()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $project->users()->attach($user);

        $response = $this->getJson(route('api.players.index', ['project' => $project->id]), [
            'x-api-key' => $user->api_key
        ]);

        $response->assertOk();

        $response->assertSee($project->name);
    }

    public function test_cannot_show_player()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $project->users()->attach($user);

        $response = $this->getJson(route('api.players.show', ['project' => $project->id]));

        $response->assertStatus(401);
    }
}
