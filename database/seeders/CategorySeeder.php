<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Schulleitung und Steuerung',
                'slug' => 'schulleitung-steuerung',
                'description' => 'Führung und strategische Ausrichtung der Schule hinsichtlich Nachhaltigkeit',
                'weight' => 1,
                'question_count' => 20
            ],
            [
                'name' => 'Unterricht und Pädagogik',
                'slug' => 'unterricht-paeddagogik',
                'description' => 'Integration nachhaltiger Themen in den Unterricht und pädagogische Methoden',
                'weight' => 1,
                'question_count' => 25
            ],
            [
                'name' => 'Schulkultur und Schulklima',
                'slug' => 'schulkultur-klima',
                'description' => 'Förderung einer nachhaltigkeitsorientierten Schulkultur und positiven Lernumgebung',
                'weight' => 1,
                'question_count' => 15
            ],
            [
                'name' => 'Kooperationen und Partnerschaften',
                'slug' => 'kooperationen-partnerschaften',
                'description' => 'Zusammenarbeit mit externen Partnern und Stakeholdern für Nachhaltigkeit',
                'weight' => 1,
                'question_count' => 15
            ],
            [
                'name' => 'Ressourcen und Infrastruktur',
                'slug' => 'ressourcen-infrastruktur',
                'description' => 'Nachhaltige Ressourcennutzung und Infrastruktur der Schule',
                'weight' => 1,
                'question_count' => 15
            ],
            [
                'name' => 'Qualitätsentwicklung',
                'slug' => 'qualitaetsentwicklung',
                'description' => 'Systematische Entwicklung und Sicherung der Nachhaltigkeitsqualität',
                'weight' => 1,
                'question_count' => 10
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
