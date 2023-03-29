<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Video;
use App\Models\Project;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectVideosTest extends TestCase
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

        $response->assertOk()->assertSee($videos[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_project_videos(): void
    {
        $project = Project::factory()->create();
        $data = Video::factory()
            ->make([
                'project_id' => $project->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.projects.videos.store', $project),
            $data
        );

        unset($data['name']);
        unset($data['mobile_path']);
        unset($data['mobile_thumbnail']);
        unset($data['interaction_id']);

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $video = Video::latest('id')->first();

        $this->assertEquals($project->id, $video->project_id);
    }
}
