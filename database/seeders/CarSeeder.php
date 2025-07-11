<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CarSeeder extends Seeder
{
    // Array with 10 different car image paths
    private $carImages = [
        'cars/audi-a4.jpg',
        'cars/bmw-3series.jpg',
        'cars/mercedes-cclass.jpg',
        'cars/volkswagen-golf.jpg',
        'cars/ford-focus.jpg',
        'cars/toyota-corolla.jpg',
        'cars/honda-civic.jpg',
        'cars/volvo-s60.jpg',
        'cars/opel-astra.jpg',
        'cars/skoda-octavia.jpg',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        foreach (range(1, 250) as $index) {
            $createdAt = Carbon::createFromTimestamp(rand(
                strtotime('2024-01-01'),
                strtotime('today')
            ));

            // Set 'sold_at' only if the car is sold
            $soldAt = null;
            if (rand(0, 1)) {
                $soldAt = Carbon::createFromTimestamp(rand(
                    strtotime('2024-01-01'),
                    strtotime('today')
                ));
            }

            // Get random image from the array
            $randomImage = $this->carImages[array_rand($this->carImages)];

            DB::table('cars')->insert([
                'user_id' => rand(1, 150),
                'license_plate' => strtoupper(Str::random(6)),
                'brand' => $faker->company,
                'model' => $faker->word,
                'price' => $faker->randomFloat(2, 5000, 50000),
                'mileage' => $faker->numberBetween(10000, 200000),
                'seats' => $faker->numberBetween(2, 7),
                'doors' => $faker->numberBetween(2, 5),
                'production_year' => $faker->numberBetween(1995, 2023),
                'weight' => $faker->randomFloat(2, 800, 3000),
                'color' => $faker->safeColorName,
                'images' => json_encode([$randomImage]), // Stored as JSON array
                'sold_at' => $soldAt,
                'views' => $faker->numberBetween(0, 1000),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}