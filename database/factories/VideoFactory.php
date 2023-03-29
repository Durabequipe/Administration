<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => $this->faker->text(255),
            'is_main' => $this->faker->boolean,
            'project_id' => \App\Models\Project::factory(),
            'position_id' => \App\Models\Position::factory(),
        ];
    }
}
