<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Interaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteractionControllerTest extends TestCase
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
    public function it_displays_index_view_with_interactions(): void
    {
        $interactions = Interaction::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('interactions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.interactions.index')
            ->assertViewHas('interactions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_interaction(): void
    {
        $response = $this->get(route('interactions.create'));

        $response->assertOk()->assertViewIs('app.interactions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_interaction(): void
    {
        $data = Interaction::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('interactions.store'), $data);

        $this->assertDatabaseHas('interactions', $data);

        $interaction = Interaction::latest('id')->first();

        $response->assertRedirect(route('interactions.edit', $interaction));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_interaction(): void
    {
        $interaction = Interaction::factory()->create();

        $response = $this->get(route('interactions.show', $interaction));

        $response
            ->assertOk()
            ->assertViewIs('app.interactions.show')
            ->assertViewHas('interaction');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_interaction(): void
    {
        $interaction = Interaction::factory()->create();

        $response = $this->get(route('interactions.edit', $interaction));

        $response
            ->assertOk()
            ->assertViewIs('app.interactions.edit')
            ->assertViewHas('interaction');
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

        $response = $this->put(
            route('interactions.update', $interaction),
            $data
        );

        $data['id'] = $interaction->id;

        $this->assertDatabaseHas('interactions', $data);

        $response->assertRedirect(route('interactions.edit', $interaction));
    }

    /**
     * @test
     */
    public function it_deletes_the_interaction(): void
    {
        $interaction = Interaction::factory()->create();

        $response = $this->delete(route('interactions.destroy', $interaction));

        $response->assertRedirect(route('interactions.index'));

        $this->assertModelMissing($interaction);
    }
}
