<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tags = DB::table('tags')->pluck('id')->toArray(); // Get all tag IDs
        shuffle($tags); // Shuffle for randomness

        $cars = DB::table('cars')->pluck('id')->toArray(); // Get all car IDs
        shuffle($cars);

        $tagIndex = 0;

        foreach ($cars as $car_id) {
            if (!isset($tags[$tagIndex])) {
                $tagIndex = 0; // Restart if we run out of tags
            }

            DB::table('car_tag')->insert([
                'car_id' => $car_id,
                'tag_id' => $tags[$tagIndex],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $tagIndex++;
        }
    }
}
