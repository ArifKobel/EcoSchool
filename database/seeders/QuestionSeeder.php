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
        $this->seedFromCsvData();
    }

    private function seedFromCsvData(): void
    {
        $csvData = $this->getCsvData();

        foreach ($csvData as $categorySlug => $data) {
            $category = \App\Models\Category::where('slug', $categorySlug)->first();
            if (!$category) {
                continue;
            }

            foreach ($data['questions'] as $questionData) {
                \App\Models\Question::create([
                    'category_id' => $category->id,
                    'question_text' => $questionData['text'],
                    'order' => $questionData['order'],
                    'is_active' => true,
                    'points' => 1,
                    'help_text' => null,
                    'metadata' => [
                        'expected_answer' => $questionData['expected_answer']
                    ]
                ]);
            }
        }
    }

    private function getCsvData(): array
    {
        return [
            'unterricht-paeddagogik' => [
                'name' => 'Unterricht und Bildungsgangarbeit',
                'questions' => [
                    ['order' => 1, 'text' => 'In einigigen ausgewiesenen Bildungsgängen ist BBNE fest im Unterricht verankert.', 'expected_answer' => false],
                    ['order' => 2, 'text' => 'In ca. der Hälfte der Bildungsgänge ist BBNE fest im Unterricht verankert.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'In den meisten Bildungsgängen der Schule ist BBNE fest im Unterricht verankert.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'In allen Bildungsgängen der Schule ist BBNE im Unterricht fest verankert.', 'expected_answer' => false],
                    ['order' => 5, 'text' => 'Fortbildungen zu BBNE werden in der Schule regelmäßig angeboten.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Das Thema BBNE ist regelmäßig Gegenstand im WuG/ Politik/ Wirtschsfts-Unterricht.', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'Ein Wahlpflichtkurs zum Thema "Nachhaltigkeit" wird angeboten.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Es wird mit nachhaltige Modellunternehmen im LF-Unterricht gearbeitet.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Es werden Realprojekte zusammen mit Schülern und Schülerinnen (z. B. Durchführung eines Umwelttages) durchgeführt.', 'expected_answer' => true],
                    ['order' => 10, 'text' => 'Das Thema BBNE wird in Form von spielerischen Ansätzen in den Unterricht integriert.', 'expected_answer' => true],
                    ['order' => 11, 'text' => 'Das Thema BBNE ist regelmäßig Bestandteil eines pädagogischen Jahrestages.', 'expected_answer' => true],
                    ['order' => 12, 'text' => 'BNE ist fester Bestandteil der didaktischen Jahresplanung.', 'expected_answer' => true],
                    ['order' => 13, 'text' => 'Lernende reflektieren im Unterricht regelmäßig ihr eigenes nachhaltiges Handeln.', 'expected_answer' => true],
                    ['order' => 14, 'text' => 'BNE-Kompetenzen sind in unseren schulinternen Curricula verankert.', 'expected_answer' => true],
                ]
            ],

            'schulkultur-klima' => [
                'name' => 'Schulleben außerhalb des Unterrichtes',
                'questions' => [
                    ['order' => 1, 'text' => 'Es findet mindestens einmal pro Jahr ein Umwelttag o. ä. statt.', 'expected_answer' => true],
                    ['order' => 2, 'text' => 'In der Schule gibt es ein Tauschhaus o. ä. für die Schüler und Schülerinnen.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Es gibt AGs oder Projekte zu Nachhaltigkeitsthemen (z. B. Umwelt-AG, Repair-Café).', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'Es besteht an der Schule eine Klima- und Nachhaltigkeitsgruppe.', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Nachhaltiges Verhalten wird im Schulleben wertgeschätzt und gefördert.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Die Schule beteiligt sich an Nachhaltigkeitsaktionen (z. B. Müllsammelaktionen, Earth Day).', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'BNE ist im Leitbild der Schule verankert.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Schülervertretung und Auszubildende können Nachhaltigkeitsthemen einbringen.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Die Schule fördert soziales Engagement (z. B. Spendenaktionen, Ehrenamt).', 'expected_answer' => true],
                    ['order' => 10, 'text' => 'Nachhaltige Mobilität (z. B. Fahrrad, ÖPNV) wird aktiv von der Schule/ Behörde unterstützt.', 'expected_answer' => true],
                    ['order' => 11, 'text' => 'Es gibt eine Steuergruppe oder ein Team, das sich mit BBNE im Schulleben beschäftigt.', 'expected_answer' => true],
                ]
            ],
            'schulleitung-steuerung' => [
                'name' => 'Schulgebäude und direkte Umgebung der Schule',
                'questions' => [
                    ['order' => 1, 'text' => 'Die Schule installiert eine CO2-Ampeln in allen Unterrichtsräumen u. a. zum klimafreundlichen Lüften.', 'expected_answer' => true],
                    ['order' => 2, 'text' => 'Die Schule hat ein umfangreiches Mülltrennungssystem (z. B. inkl. Elektrokleingeräte, Batterien), das auch aktiv umgesetzt wird.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Die Schule nutzt Ökostrom oder strebt dies an.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'Das Außengelände wird ökologisch genutzt (z. B. Schulgarten, Blühwiese, Insektenhotels)', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Es gibt Hinweise und Materialien zum nachhaltigen Verhalten im Gebäude.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'In der Schule wird auf energieeffiziente Beleuchtung und Geräte geachtet.', 'expected_answer' => false],
                    ['order' => 7, 'text' => 'Reparaturen innerhalb der Schule werden möglichst nachhaltig umgesetzt.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Bei Investitionen werden Kriterien der nachhaltigen Beschaffung beachtet.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Das Schulgebäude ist energetisch auf dem aktuellen Stand.', 'expected_answer' => false],
                    ['order' => 10, 'text' => 'Es werden Maßnahmen im Rahmen von Energie hoch 4 und W.I.R. umgesetzt.', 'expected_answer' => true],
                ]
            ],
            'verbreitung-sichtbarmachung' => [
                'name' => 'Verbreitung und Sichtbarmachung',
                'questions' => [
                    ['order' => 1, 'text' => 'Über die Nachhaltigkeitsaktivitäten wird auf der Schulhomepage regelmäßig berichtet', 'expected_answer' => true],
                    ['order' => 2, 'text' => 'Die Schule hat eine Beauftragte für Öffentlichkeitsarbeit, die regelmäßig über BBNE-Aktivitäten berichtet.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Es gibt eine BBNE-Präsentation im Eingangsbereich oder auf Infoflächen.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'Es gibt eine öffentlich zugängliche Nachhaltigkeitsstrategie der Schule.', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Schulinterne Veranstaltungen zu BBNE werden gezielt öffentlich gemacht.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Die Schule pflegt eine aktive Kommunikation zu BBNE mit Betrieben, Kammern und Verbänden', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'BNE-Erfolge sind Teil von Schulpräsentationen (z. B. bei Tagen der offenen Tür).', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Ein Newsletter oder Rundbrief informiert regelmäßig über BBNE-Aktivitäten.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Die Schule veröffentlicht regelmäßig BBNE-bezogene Beiträge in sozialen Medien.', 'expected_answer' => true],
                ]
            ],
            'qualitaetsentwicklung' => [
                'name' => 'Schulverpflegung',
                'questions' => [
                    ['order' => 1, 'text' => 'Die Schulkantine bietet gesundes Essen an, z. B. in Form einer Salatbar.', 'expected_answer' => true],
                    ['order' => 2, 'text' => 'Die Kantine hat ein Pfandystem für Kaffee- und Trinkbecher.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Die Kantine bietet mehrmals pro Woche veganes oder vegetarisches Essen an.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'In der Kantine wird versucht, das Müllaufkommen zu verringern.', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Bei der Essenszubereitung werden saisonale und regionale Produkte verwendet.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Die Kantine bietet fair gehandelte Lebensmittel an und bewirbt diese aktiv.', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'Essensanbieter werden auf Nachhaltigkeitskriterien überprüft.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Es gibt Mitgestaltungsmöglichkeiten für Lernende bei der Schulverpflegung.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Eine nachhaltige Verpflegung ist Thema im Unterricht oder Projekten.', 'expected_answer' => true],
                    ['order' => 10, 'text' => 'Die Herkunft der Lebensmittel wird transparent gemacht.', 'expected_answer' => true],
                ]
            ],
            'kooperationen-partnerschaften' => [
                'name' => 'Kooperationen, Vernetzung und Internationalisierung',
                'questions' => [
                    ['order' => 1, 'text' => 'Die Lernortkooperation wird aktiv genutzt, um Umweltschutz und Klimabildung in den Bildungsgängen zu verankern', 'expected_answer' => false],
                    ['order' => 2, 'text' => 'Es findet ein Austauschprogramm zu BBNE-Themen mit Ländern des globalen Südens statt.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Externe Experten zu BBNE-Themen werden regelmäßig eingeladen.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'Es gibt Kooperationen mit Umwelt- oder Sozialverbänden.', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Internationale Partnerschaften und Kooperationen haben eine nachhaltige Ausrichtung.', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Projekte mit Partnerländern behandeln BBNE-relevante Themen.', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'Die Kooperation mit Kammern oder Innungen bezieht auch BBNE ein.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Lernende und Lehrende nehmen an internationalen Austauschprogrammen mit BBNE-Bezug teil.', 'expected_answer' => true],
                    ['order' => 9, 'text' => 'Die Schule beteiligt sich an regionalen oder bundesweiten BBNE-Initiativen.', 'expected_answer' => true],
                    ['order' => 10, 'text' => 'Die Schule ist in lokale Bildungsnetzwerke zu Nachhaltigkeit eingebunden.', 'expected_answer' => true],
                ]
            ],
            'ressourcen-infrastruktur' => [
                'name' => 'Auszeichnungen und Wettbewerbe',
                'questions' => [
                    ['order' => 1, 'text' => 'Die Schule hat das Gütesiegel Hamburger Klimaschule', 'expected_answer' => true],
                    ['order' => 2, 'text' => 'Lernende nehmen regelmäßig an BBNE-relevanten Wettbewerben teil.', 'expected_answer' => true],
                    ['order' => 3, 'text' => 'Die Schule nimmt an weiteren Wettbewerben zu (B)BNE regelmäßig teil.', 'expected_answer' => true],
                    ['order' => 4, 'text' => 'Die Schule hat das Siegel Umweltschule in Europa', 'expected_answer' => true],
                    ['order' => 5, 'text' => 'Es gibt gezielte Unterstützung bei der Wettbewerbsteilnahme (z. B. durch Lehrkräfte).', 'expected_answer' => true],
                    ['order' => 6, 'text' => 'Es gibt ein internes Anerkennungssystem für nachhaltiges Engagement.', 'expected_answer' => true],
                    ['order' => 7, 'text' => 'Erfolge bei Nachhaltigkeitswettbewerben werden schulintern gewürdigt.', 'expected_answer' => true],
                    ['order' => 8, 'text' => 'Es wird systematisch überprüft, welche Auszeichnungen zur Schule passen.', 'expected_answer' => false],
                    ['order' => 9, 'text' => 'Wettbewerbe und Auszeichnungen sind Thema in Schulöffentlichkeit und Medien.', 'expected_answer' => true],
                ]
            ],
        ];
    }
}
