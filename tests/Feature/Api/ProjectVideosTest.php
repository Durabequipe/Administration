<?php

namespace Tests\Feature\Api;

use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectVideosTest extends TestCase
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
    public function it_gets_project_videos(): void
    {
        $project = Project::factory()->create();
        $videos = Video::factory()
            ->count(2)
            ->create([
                'project_id' => $project->id,
            ]);

        $response = $this->getJson(
            route('api.projects.videos.index', $project)
        );

        $response->assertOk();
    }

    /**
     * @test
     */
    public function it_stores_the_project_videos(): void
    {
        $project = Project::factory()->create();
        $interaction = Interaction::factory()->create();
        $data = Video::factory()
            ->make([
                'project_id' => $project->id,
                'interaction_id' => $interaction->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.projects.videos.store', $project),
            $data
        );

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201);

        $video = Video::latest('id')->first();

        $this->assertEquals($project->id, $video->project_id);
    }
}
