<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Town;
use App\Models\Province;
use Faker\Factory;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(TownSeeder::class);
        // $this->call(ProvinceSeeder::class);

        Town::factory(10)->create()->each(function ($town) {
            $faker = Factory::create();
            Province::factory(5)->create(
                [
                    'towns_id' => $town->id,
                    'postcode' => fn () => $town->short_postcode . str_pad($faker->unique()->numberBetween(0, 999), 3, '0', STR_PAD_LEFT)
                ]
            );
        });
    }
}
