<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Video;

use App\Models\Project;
use App\Models\Interaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_videos(): void
    {
        $videos = Video::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('videos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.videos.index')
            ->assertViewHas('videos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_video(): void
    {
        $response = $this->get(route('videos.create'));

        $response->assertOk()->assertViewIs('app.videos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_video(): void
    {
        $data = Video::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('videos.store'), $data);

        unset($data['mobile_path']);
        unset($data['mobile_thumbnail']);
        unset($data['interaction_id']);

        $this->assertDatabaseHas('videos', $data);

        $video = Video::latest('id')->first();

        $response->assertRedirect(route('videos.edit', $video));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_video(): void
    {
        $video = Video::factory()->create();

        $response = $this->get(route('videos.show', $video));

        $response
            ->assertOk()
            ->assertViewIs('app.videos.show')
            ->assertViewHas('video');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_video(): void
    {
        $video = Video::factory()->create();

        $response = $this->get(route('videos.edit', $video));

        $response
            ->assertOk()
            ->assertViewIs('app.videos.edit')
            ->assertViewHas('video');
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
            'desktop_path' => $this->faker->text(255),
            'mobile_path' => $this->faker->text(255),
            'mobile_thumbnail' => $this->faker->text(255),
            'is_main' => $this->faker->boolean,
            'project_id' => $project->id,
            'interaction_id' => $interaction->id,
        ];

        $response = $this->put(route('videos.update', $video), $data);

        unset($data['mobile_path']);
        unset($data['mobile_thumbnail']);
        unset($data['interaction_id']);

        $data['id'] = $video->id;

        $this->assertDatabaseHas('videos', $data);

        $response->assertRedirect(route('videos.edit', $video));
    }

    /**
     * @test
     */
    public function it_deletes_the_video(): void
    {
        $video = Video::factory()->create();

        $response = $this->delete(route('videos.destroy', $video));

        $response->assertRedirect(route('videos.index'));

        $this->assertSoftDeleted($video);
    }
}
