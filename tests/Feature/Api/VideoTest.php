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

class VideoTest extends TestCase
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
    public function it_gets_videos_list(): void
    {
        $videos = Video::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.videos.index'));

        $response->assertOk()->assertSee($videos[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_video(): void
    {
        $interaction = Interaction::factory()->create();
        $data = Video::factory()
            ->make([
                'interaction_id' => $interaction->id,
            ])
            ->toArray();

        $response = $this->postJson(route('api.videos.store'), $data);

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201);
    }

    /**
     * @test
     */
    public function it_updates_the_video(): void
    {
        $video = Video::factory()->create();

        $project = Project::factory()->create();
        $interaction = Interaction::factory()->create();

        $data = [
            'project_id' => $project->id,
            'name' => $this->faker->name(),
            'desktop_path' => $this->faker->word(),
            'mobile_path' => $this->faker->word(),
            'is_main' => $this->faker->boolean,
            'interaction_id' => $interaction->id,
        ];

        $response = $this->putJson(route('api.videos.update', $video), $data);

        $data['id'] = $video->id;

        unset($data['is_main']);

        $this->assertDatabaseHas('videos', $data);

        $response->assertOk();
    }

    /**
     * @test
     */
    public function it_deletes_the_video(): void
    {
        $video = Video::factory()->create();

        $response = $this->deleteJson(route('api.videos.destroy', $video));

        $this->assertSoftDeleted($video);

        $response->assertNoContent();
    }
}
