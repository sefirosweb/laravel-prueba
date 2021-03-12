<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Province::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'province_name' => $this->faker->unique()->state,
            'postcode' => str_pad($this->faker->unique()->numberBetween(0, 99999), 5, '0', STR_PAD_LEFT),
            'towns_id' => rand(1, 10)
        ];
    }
}
