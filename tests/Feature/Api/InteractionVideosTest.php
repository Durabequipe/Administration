<?php

namespace Tests\Feature\Api;

use App\Models\Interaction;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InteractionVideosTest extends TestCase
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
    public function it_gets_interaction_videos(): void
    {
        $interaction = Interaction::factory()->create();
        $videos = Video::factory()
            ->count(2)
            ->create([
                'interaction_id' => $interaction->id,
            ]);

        $response = $this->getJson(
            route('api.interactions.videos.index', $interaction)
        );

        $response->assertOk();
    }

    /**
     * @test
     */
    public function it_stores_the_interaction_videos(): void
    {
        $interaction = Interaction::factory()->create();
        $data = Video::factory()
            ->make([
                'interaction_id' => $interaction->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.interactions.videos.store', $interaction),
            $data
        );

        $this->assertDatabaseHas('videos', $data);

        $response->assertStatus(201);

        $video = Video::latest('id')->first();

        $this->assertEquals($interaction->id, $video->interaction_id);
    }
}
