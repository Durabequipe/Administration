<?php

namespace Database\Factories;

use App\Models\Interaction;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InteractionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Interaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'delay' => $this->faker->randomElement([10, 20]),
            'position' => $this->faker->randomElement(['bottom', 'full']),
        ];
    }
}
