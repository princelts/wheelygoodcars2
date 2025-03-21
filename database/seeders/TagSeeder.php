<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'SUV', 'Sedan', 'Hatchback', 'Cabrio', 'Coupe', 'MPV',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), // Random hex kleur
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
