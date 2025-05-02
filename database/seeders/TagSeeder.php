<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    // Definieer tag groepen waar tags niet samen voor kunnen komen voor één auto
    private $tagGroups = [
        'Brandstof Type' => [
            'Benzine', 'Diesel', 'Elektrisch', 'Hybride', 'Plug-in Hybride', 'LPG', 'Waterstof'
        ],
        'Aandrijving' => [
            'Voorwielaandrijving', 'Achterwielaandrijving', 'Vierwielaandrijving', '4x4'
        ],
        'Transmissie' => [
            'Handgeschakeld', 'Automaat', 'Halfautomaat', 'CVT'
        ],
        'Carrosserie' => [
            'SUV', 'Sedan', 'Hatchback', 'Cabrio', 'Coupé', 'MPV', 'Station', 'Pick-up', 'Bestelwagen'
        ],
        'Voertuigklasse' => [
            'Economy', 'Compact', 'Middenklasse', 'Topklasse', 'Luxe', 'Sport', 'Supercar'
        ],
        'Uitrusting' => [
            'Zonnepaneldak', 'Leren bekleding', 'Navigatie', 'Parkeersensoren',
            'Achteruitrijcamera', 'Verwarmde stoelen', 'Keyless entry', 'Premium geluidssysteem',
            'Lightmetal velgen', 'Getinte ramen', 'Trekhaken', 'Dakdrager'
        ],
        'Conditie' => [
            'Nieuw', 'Zo goed als nieuw', 'Gebruikt', 'Defect', 'Demonstratie'
        ],
        'Gebruik' => [
            'Gezin', 'Zakelijk', 'Prestatie', 'Off-road', 'Stad', 'Klassieker'
        ]
    ];

    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        foreach ($this->tagGroups as $group => $tags) {
            foreach ($tags as $tag) {
                DB::table('tags')->insert([
                    'name' => $tag,
                    'group' => $group,
                    'color' => $this->getColorForGroup($group),
                    'used_count' => 0,
                    'used_sold_count' => 0,
                    'used_unsold_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getColorForGroup($group)
    {
        $colors = [
            'brandstof_type' => '#FF5733', // Oranjerood
            'aandrijving' => '#3380FF', // Blauw
            'transmissie' => '#33FF57', // Groen
            'carrosserie' => '#F033FF', // Paars
            'voertuigklasse' => '#FF33F0', // Roze
            'uitrusting' => '#33FFF0', // Cyaan
            'conditie' => '#FFC733', // Geeloranje
            'gebruik' => '#8A33FF' // Violet
        ];
        
        return $colors[$group] ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}