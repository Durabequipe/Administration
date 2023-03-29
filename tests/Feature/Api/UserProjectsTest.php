<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Project;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_projects(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $user->projects()->attach($project);

        $response = $this->getJson(route('api.users.projects.index', $user));

        $response->assertOk()->assertSee($project->name);
    }

    /**
     * @test
     */
    public function it_can_attach_projects_to_user(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->postJson(
            route('api.users.projects.store', [$user, $project])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->projects()
                ->where('projects.id', $project->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_projects_from_user(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->deleteJson(
            route('api.users.projects.store', [$user, $project])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->projects()
                ->where('projects.id', $project->id)
                ->exists()
        );
    }
}
