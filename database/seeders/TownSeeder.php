<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Town::factory(50)->create();
    }
}
