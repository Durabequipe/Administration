<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Position;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionControllerTest extends TestCase
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
    public function it_displays_index_view_with_positions(): void
    {
        $positions = Position::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('positions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.positions.index')
            ->assertViewHas('positions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_position(): void
    {
        $response = $this->get(route('positions.create'));

        $response->assertOk()->assertViewIs('app.positions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_position(): void
    {
        $data = Position::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('positions.store'), $data);

        $this->assertDatabaseHas('positions', $data);

        $position = Position::latest('id')->first();

        $response->assertRedirect(route('positions.edit', $position));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_position(): void
    {
        $position = Position::factory()->create();

        $response = $this->get(route('positions.show', $position));

        $response
            ->assertOk()
            ->assertViewIs('app.positions.show')
            ->assertViewHas('position');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_position(): void
    {
        $position = Position::factory()->create();

        $response = $this->get(route('positions.edit', $position));

        $response
            ->assertOk()
            ->assertViewIs('app.positions.edit')
            ->assertViewHas('position');
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

        $response = $this->put(route('positions.update', $position), $data);

        $data['id'] = $position->id;

        $this->assertDatabaseHas('positions', $data);

        $response->assertRedirect(route('positions.edit', $position));
    }

    /**
     * @test
     */
    public function it_deletes_the_position(): void
    {
        $position = Position::factory()->create();

        $response = $this->delete(route('positions.destroy', $position));

        $response->assertRedirect(route('positions.index'));

        $this->assertSoftDeleted($position);
    }
}
