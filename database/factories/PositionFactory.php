<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'x' => $this->faker->randomNumber(0),
            'y' => $this->faker->randomNumber(0),
            'zindex' => $this->faker->randomNumber(0),
            'type' => $this->faker->text(255),
        ];
    }
}
