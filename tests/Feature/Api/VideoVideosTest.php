<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Video;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoVideosTest extends TestCase
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
    public function it_gets_video_videos(): void
    {
        $video = Video::factory()->create();
        $video = Video::factory()->create();

        $video->videos()->attach($video);

        $response = $this->getJson(route('api.videos.videos.index', $video));

        $response->assertOk()->assertSee($video->desktop_path);
    }

    /**
     * @test
     */
    public function it_can_attach_videos_to_video(): void
    {
        $video = Video::factory()->create();
        $video = Video::factory()->create();

        $response = $this->postJson(
            route('api.videos.videos.store', [$video, $video])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $video
                ->videos()
                ->where('videos.id', $video->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_videos_from_video(): void
    {
        $video = Video::factory()->create();
        $video = Video::factory()->create();

        $response = $this->deleteJson(
            route('api.videos.videos.store', [$video, $video])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $video
                ->videos()
                ->where('videos.id', $video->id)
                ->exists()
        );
    }
}
