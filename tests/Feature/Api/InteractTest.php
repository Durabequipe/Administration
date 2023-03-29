<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Interact;

use App\Models\Video;
use App\Models\Position;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteractTest extends TestCase
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
    public function it_gets_interacts_list(): void
    {
        $interacts = Interact::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.interacts.index'));

        $response->assertOk()->assertSee($interacts[0]->content);
    }

    /**
     * @test
     */
    public function it_stores_the_interact(): void
    {
        $data = Interact::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.interacts.store'), $data);

        $this->assertDatabaseHas('interacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_interact(): void
    {
        $interact = Interact::factory()->create();

        $video = Video::factory()->create();
        $position = Position::factory()->create();
        $video = Video::factory()->create();

        $data = [
            'content' => $this->faker->text,
            'video_id' => $video->id,
            'position_id' => $position->id,
            'link_to' => $video->id,
        ];

        $response = $this->putJson(
            route('api.interacts.update', $interact),
            $data
        );

        $data['id'] = $interact->id;

        $this->assertDatabaseHas('interacts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_interact(): void
    {
        $interact = Interact::factory()->create();

        $response = $this->deleteJson(
            route('api.interacts.destroy', $interact)
        );

        $this->assertSoftDeleted($interact);

        $response->assertNoContent();
    }
}
