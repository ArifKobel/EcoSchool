<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCategories();
    }

    private function seedCategories(): void
    {
        $this->seedSchulleitungSteuerung();
        $this->seedUnterrichtPaedagogik();
        $this->seedSchulkulturKlima();
        $this->seedKooperationenPartnerschaften();
        $this->seedRessourcenInfrastruktur();
        $this->seedQualitaetsentwicklung();
    }

    private function seedSchulleitungSteuerung(): void
    {
        $category = \App\Models\Category::where('slug', 'schulleitung-steuerung')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Gibt es eine schriftliche Nachhaltigkeitsstrategie der Schule?', 'help_text' => 'Eine dokumentierte Strategie zeigt langfristiges Engagement'],
            ['text' => 'Gibt es Budget für Nachhaltigkeitsprojekte?', 'help_text' => 'Finanzielle Ressourcen für Umsetzung']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }

    private function createQuestionsForCategory(\App\Models\Category $category, array $questions): void
    {
        foreach ($questions as $index => $questionData) {
            \App\Models\Question::create([
                'category_id' => $category->id,
                'question_text' => $questionData['text'],
                'order' => $index + 1,
                'is_active' => true,
                'points' => 1,
                'help_text' => $questionData['help_text'] ?? null
            ]);
        }
    }

    private function seedUnterrichtPaedagogik(): void
    {
        $category = \App\Models\Category::where('slug', 'unterricht-paeddagogik')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Werden Nachhaltigkeitsthemen fächerübergreifend behandelt?', 'help_text' => 'Interdisziplinäre Betrachtung komplexer Themen'],
            ['text' => 'Nutzen Lehrkräfte projektbasiertes Lernen zu Nachhaltigkeitsthemen?', 'help_text' => 'Praxisorientierte Lernmethoden']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }

    private function seedSchulkulturKlima(): void
    {
        $category = \App\Models\Category::where('slug', 'schulkultur-klima')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Gibt es eine nachhaltige Schulkultur?', 'help_text' => 'Gemeinsame Werte und Normen'],
            ['text' => 'Werden nachhaltige Verhaltensweisen aktiv gefördert?', 'help_text' => 'Positive Verstärkung wünschenswerter Verhaltensweisen']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }

    private function seedKooperationenPartnerschaften(): void
    {
        $category = \App\Models\Category::where('slug', 'kooperationen-partnerschaften')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Gibt es Kooperationen mit lokalen Unternehmen?', 'help_text' => 'Praxispartner für Nachhaltigkeitsprojekte']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }

    private function seedRessourcenInfrastruktur(): void
    {
        $category = \App\Models\Category::where('slug', 'ressourcen-infrastruktur')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Wird erneuerbare Energie in der Schule genutzt?', 'help_text' => 'Energetische Nachhaltigkeit'],
            ['text' => 'Werden Abfälle getrennt gesammelt?', 'help_text' => 'Ressourcenschonung und Recycling']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }

    private function seedQualitaetsentwicklung(): void
    {
        $category = \App\Models\Category::where('slug', 'qualitaetsentwicklung')->first();
        if (!$category) return;

        $questions = [
            ['text' => 'Gibt es ein Qualitätsmanagementsystem für Nachhaltigkeit?', 'help_text' => 'Systematische Qualitätssicherung']
        ];

        $this->createQuestionsForCategory($category, $questions);
    }
}
