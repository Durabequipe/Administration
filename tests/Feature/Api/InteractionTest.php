<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Interaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteractionTest extends TestCase
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
    public function it_gets_interactions_list(): void
    {
        $interactions = Interaction::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.interactions.index'));

        $response->assertOk()->assertSee($interactions[0]->position);
    }

    /**
     * @test
     */
    public function it_stores_the_interaction(): void
    {
        $data = Interaction::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.interactions.store'), $data);

        $this->assertDatabaseHas('interactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_interaction(): void
    {
        $interaction = Interaction::factory()->create();

        $data = [
            'delay' => $this->faker->randomElement([10, 20]),
            'position' => $this->faker->randomElement(['bottom', 'full']),
        ];

        $response = $this->putJson(
            route('api.interactions.update', $interaction),
            $data
        );

        $data['id'] = $interaction->id;

        $this->assertDatabaseHas('interactions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_interaction(): void
    {
        $interaction = Interaction::factory()->create();

        $response = $this->deleteJson(
            route('api.interactions.destroy', $interaction)
        );

        $this->assertModelMissing($interaction);

        $response->assertNoContent();
    }
}
