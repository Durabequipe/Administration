<?php

namespace Database\Factories;

use App\Models\Interaction;
use App\Models\Project;
use App\Models\Video;
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
            'name' => $this->faker->name(),
            'desktop_path' => $this->faker->word(),
            'mobile_path' => $this->faker->word(),
            'is_main' => $this->faker->boolean,
            'project_id' => Project::factory(),
            'interaction_id' => Interaction::factory(),
        ];
    }
}
