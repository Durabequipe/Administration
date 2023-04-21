<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_project_users(): void
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $project->users()->attach($user);

        $response = $this->getJson(route('api.projects.users.index', $project));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_project(): void
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.projects.users.store', [$project, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $project
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_project(): void
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.projects.users.store', [$project, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $project
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
