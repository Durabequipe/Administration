<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Video;
use App\Models\Interact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoInteractsTest extends TestCase
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
    public function it_gets_video_interacts(): void
    {
        $video = Video::factory()->create();
        $interacts = Interact::factory()
            ->count(2)
            ->create([
                'link_to' => $video->id,
            ]);

        $response = $this->getJson(route('api.videos.interacts.index', $video));

        $response->assertOk()->assertSee($interacts[0]->content);
    }

    /**
     * @test
     */
    public function it_stores_the_video_interacts(): void
    {
        $video = Video::factory()->create();
        $data = Interact::factory()
            ->make([
                'link_to' => $video->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.videos.interacts.store', $video),
            $data
        );

        $this->assertDatabaseHas('interacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $interact = Interact::latest('id')->first();

        $this->assertEquals($video->id, $interact->link_to);
    }
}
