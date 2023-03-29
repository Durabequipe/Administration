<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Interact;

use App\Models\Video;
use App\Models\Position;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InteractControllerTest extends TestCase
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
    public function it_displays_index_view_with_interacts(): void
    {
        $interacts = Interact::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('interacts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.interacts.index')
            ->assertViewHas('interacts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_interact(): void
    {
        $response = $this->get(route('interacts.create'));

        $response->assertOk()->assertViewIs('app.interacts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_interact(): void
    {
        $data = Interact::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('interacts.store'), $data);

        $this->assertDatabaseHas('interacts', $data);

        $interact = Interact::latest('id')->first();

        $response->assertRedirect(route('interacts.edit', $interact));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_interact(): void
    {
        $interact = Interact::factory()->create();

        $response = $this->get(route('interacts.show', $interact));

        $response
            ->assertOk()
            ->assertViewIs('app.interacts.show')
            ->assertViewHas('interact');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_interact(): void
    {
        $interact = Interact::factory()->create();

        $response = $this->get(route('interacts.edit', $interact));

        $response
            ->assertOk()
            ->assertViewIs('app.interacts.edit')
            ->assertViewHas('interact');
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

        $response = $this->put(route('interacts.update', $interact), $data);

        $data['id'] = $interact->id;

        $this->assertDatabaseHas('interacts', $data);

        $response->assertRedirect(route('interacts.edit', $interact));
    }

    /**
     * @test
     */
    public function it_deletes_the_interact(): void
    {
        $interact = Interact::factory()->create();

        $response = $this->delete(route('interacts.destroy', $interact));

        $response->assertRedirect(route('interacts.index'));

        $this->assertSoftDeleted($interact);
    }
}
