<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class CarTagSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        $tags = Tag::all()->groupBy('group');
        
        foreach ($cars as $car) {
            $carTags = [];
            
            // Voeg tags toe uit exclusieve groepen
            $carTags[] = $tags['brandstof_type']->random()->id;
            $carTags[] = $tags['aandrijving']->random()->id;
            $carTags[] = $tags['transmissie']->random()->id;
            $carTags[] = $tags['carrosserie']->random()->id;
            $carTags[] = $tags['voertuigklasse']->random()->id;
            $carTags[] = $tags['conditie']->random()->id;
            
            // Voeg gebruik en uitrusting tags toe
            $carTags = array_merge(
                $carTags,
                $tags['gebruik']->random(rand(1, 3))->pluck('id')->toArray(),
                $tags['uitrusting']->random(rand(3, 6))->pluck('id')->toArray()
            );
            
            $carTags = array_unique($carTags);
            $car->tags()->sync($carTags);
            
            // Update tag statistieken
            $this->updateTagStatistics($car, $carTags);
        }
    }
    
    private function updateTagStatistics(Car $car, array $tagIds)
    {
        $isSold = !is_null($car->sold_at);
        
        foreach ($tagIds as $tagId) {
            $update = [
                'used_count' => DB::raw('used_count + 1')
            ];
            
            if ($isSold) {
                $update['used_sold_count'] = DB::raw('used_sold_count + 1');
            } else {
                $update['used_unsold_count'] = DB::raw('used_unsold_count + 1');
            }
            
            DB::table('tags')
                ->where('id', $tagId)
                ->update($update);
        }
    }
}