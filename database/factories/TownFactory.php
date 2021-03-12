<?php

namespace Database\Factories;

use App\Models\Town;
use Illuminate\Database\Eloquent\Factories\Factory;

class TownFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Town::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'town_name' => $this->faker->unique()->city,
            'short_postcode' => str_pad($this->faker->unique()->numberBetween(0, 99), 2, '0', STR_PAD_LEFT)
        ];
    }
}
