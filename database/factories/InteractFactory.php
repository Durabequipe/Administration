<?php

namespace Database\Factories;

use App\Models\Interact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InteractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->text,
            'video_id' => \App\Models\Video::factory(),
            'position_id' => \App\Models\Position::factory(),
            'link_to' => \App\Models\Video::factory(),
        ];
    }
}
