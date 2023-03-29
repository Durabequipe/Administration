<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Position;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
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
    public function it_gets_positions_list(): void
    {
        $positions = Position::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.positions.index'));

        $response->assertOk()->assertSee($positions[0]->type);
    }

    /**
     * @test
     */
    public function it_stores_the_position(): void
    {
        $data = Position::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.positions.store'), $data);

        $this->assertDatabaseHas('positions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_position(): void
    {
        $position = Position::factory()->create();

        $data = [
            'x' => $this->faker->randomNumber(0),
            'y' => $this->faker->randomNumber(0),
            'zindex' => $this->faker->randomNumber(0),
            'type' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.positions.update', $position),
            $data
        );

        $data['id'] = $position->id;

        $this->assertDatabaseHas('positions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_position(): void
    {
        $position = Position::factory()->create();

        $response = $this->deleteJson(
            route('api.positions.destroy', $position)
        );

        $this->assertSoftDeleted($position);

        $response->assertNoContent();
    }
}
