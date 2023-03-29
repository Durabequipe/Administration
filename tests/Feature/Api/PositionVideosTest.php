<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Video;
use App\Models\Position;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionVideosTest extends TestCase
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
    public function it_gets_position_videos(): void
    {
        $position = Position::factory()->create();
        $videos = Video::factory()
            ->count(2)
            ->create([
                'position_id' => $position->id,
            ]);

        $response = $this->getJson(
            route('api.positions.videos.index', $position)
        );

        $response->assertOk()->assertSee($videos[0]->path);
    }

    /**
     * @test
     */
    public function it_stores_the_position_videos(): void
    {
        $position = Position::factory()->create();
        $data = Video::factory()
            ->make([
                'position_id' => $position->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.positions.videos.store', $position),
            $data
        );

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $video = Video::latest('id')->first();

        $this->assertEquals($position->id, $video->position_id);
    }
}
