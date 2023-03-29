<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Video;

use App\Models\Project;
use App\Models\Interaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
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
        $data = Video::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.videos.store'), $data);

        unset($data['name']);
        unset($data['mobile_path']);
        unset($data['mobile_thumbnail']);
        unset($data['interaction_id']);

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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
            'project_id' => $this->faker->uuid,
            'name' => $this->faker->name(),
            'desktop_path' => $this->faker->text(255),
            'mobile_path' => $this->faker->text(255),
            'mobile_thumbnail' => $this->faker->text(255),
            'is_main' => $this->faker->boolean,
            'interaction_id' => $this->faker->randomNumber,
            'project_id' => $project->id,
            'interaction_id' => $interaction->id,
        ];

        $response = $this->putJson(route('api.videos.update', $video), $data);

        unset($data['name']);
        unset($data['mobile_path']);
        unset($data['mobile_thumbnail']);
        unset($data['interaction_id']);

        $data['id'] = $video->id;

        $this->assertDatabaseHas('videos', $data);

        $response->assertOk()->assertJsonFragment($data);
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
