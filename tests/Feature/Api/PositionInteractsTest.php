<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Position;
use App\Models\Interact;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionInteractsTest extends TestCase
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
    public function it_gets_position_interacts(): void
    {
        $position = Position::factory()->create();
        $interacts = Interact::factory()
            ->count(2)
            ->create([
                'position_id' => $position->id,
            ]);

        $response = $this->getJson(
            route('api.positions.interacts.index', $position)
        );

        $response->assertOk()->assertSee($interacts[0]->content);
    }

    /**
     * @test
     */
    public function it_stores_the_position_interacts(): void
    {
        $position = Position::factory()->create();
        $data = Interact::factory()
            ->make([
                'position_id' => $position->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.positions.interacts.store', $position),
            $data
        );

        $this->assertDatabaseHas('interacts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $interact = Interact::latest('id')->first();

        $this->assertEquals($position->id, $interact->position_id);
    }
}
