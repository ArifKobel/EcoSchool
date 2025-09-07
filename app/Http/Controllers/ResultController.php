<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function show(Result $result)
    {
        if ($result->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $categories = Category::all();

        // Verbesserungsvorschläge basierend auf dem Status
        $recommendations = $this->getRecommendations($result);

        // Ressourcen basierend auf dem Status
        $resources = $this->getResources($result->status);

        return view('results.show', compact(
            'result',
            'user',
            'categories',
            'recommendations',
            'resources'
        ));
    }

    /**
     * Generiere Verbesserungsvorschläge basierend auf dem Status
     */
    private function getRecommendations(Result $result)
    {
        $recommendations = [];

        switch ($result->status) {
            case 'bronze':
                $recommendations = $this->getBronzeRecommendations($result);
                break;
            case 'silver':
                $recommendations = $this->getSilverRecommendations($result);
                break;
            case 'gold':
                $recommendations = $this->getGoldRecommendations($result);
                break;
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Bronze-Status
     */
    private function getBronzeRecommendations(Result $result)
    {
        $recommendations = [
            'general' => [
                'Erstellen Sie eine schriftliche Nachhaltigkeitsstrategie für Ihre Schule',
                'Benennen Sie eine verantwortliche Person für Nachhaltigkeitsthemen',
                'Integrieren Sie Nachhaltigkeit in die Schulordnung',
                'Planen Sie ein Budget für Nachhaltigkeitsprojekte ein'
            ]
        ];

        // Kategoriespezifische Empfehlungen
        if (isset($result->category_scores)) {
            foreach ($result->category_scores as $categorySlug => $scores) {
                if ($scores['percentage'] < 50) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'bronze');
                }
            }
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Silber-Status
     */
    private function getSilverRecommendations(Result $result)
    {
        $recommendations = [
            'general' => [
                'Entwickeln Sie ein umfassendes Qualitätsmanagementsystem',
                'Bauen Sie Partnerschaften mit externen Organisationen aus',
                'Führen Sie regelmäßige Fortbildungen durch',
                'Implementieren Sie ein Energiemanagementsystem'
            ]
        ];

        // Kategoriespezifische Empfehlungen
        if (isset($result->category_scores)) {
            foreach ($result->category_scores as $categorySlug => $scores) {
                if ($scores['percentage'] < 70) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'silver');
                }
            }
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Gold-Status
     */
    private function getGoldRecommendations(Result $result)
    {
        $recommendations = [
            'general' => [
                'Streben Sie Zertifizierungen an (z.B. Öko-Schule, Energieeffizienz)',
                'Bauen Sie ein Netzwerk mit anderen nachhaltigen Schulen auf',
                'Entwickeln Sie sich zu einem Vorbild in der Region',
                'Teilen Sie Ihre Erfahrungen und Materialien mit anderen Schulen'
            ]
        ];

        // Kategoriespezifische Empfehlungen für höchste Exzellenz
        if (isset($result->category_scores)) {
            foreach ($result->category_scores as $categorySlug => $scores) {
                if ($scores['percentage'] < 90) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'gold');
                }
            }
        }

        return $recommendations;
    }

    /**
     * Kategoriespezifische Empfehlungen
     */
    private function getCategoryRecommendations($categorySlug, $level)
    {
        $recommendations = [
            'schulleitung-steuerung' => [
                'bronze' => ['Erstellen Sie eine Nachhaltigkeitsstrategie', 'Benennen Sie Verantwortliche'],
                'silver' => ['Entwickeln Sie Indikatoren für den Erfolg', 'Führen Sie regelmäßige Evaluationen durch'],
                'gold' => ['Streben Sie nach Zertifizierungen', 'Bauen Sie ein Qualitätsmanagementsystem auf']
            ],
            'unterricht-paeddagogik' => [
                'bronze' => ['Integrieren Sie Nachhaltigkeitsthemen in den Unterricht', 'Beschaffen Sie Unterrichtsmaterialien'],
                'silver' => ['Entwickeln Sie fächerübergreifende Projekte', 'Bilden Sie Multiplikatoren aus'],
                'gold' => ['Entwickeln Sie innovative Lehrmethoden', 'Bauen Sie Partnerschaften mit Universitäten auf']
            ],
            'schulkultur-klima' => [
                'bronze' => ['Fördern Sie nachhaltige Verhaltensweisen', 'Schaffen Sie eine positive Fehlerkultur'],
                'silver' => ['Entwickeln Sie Rituale für Nachhaltigkeit', 'Bauen Sie eine Kultur der Achtsamkeit auf'],
                'gold' => ['Werden Sie Vorbild in der Region', 'Fördern Sie ehrenamtliches Engagement']
            ],
            'kooperationen-partnerschaften' => [
                'bronze' => ['Bauen Sie lokale Partnerschaften auf', 'Kooperieren Sie mit Unternehmen'],
                'silver' => ['Entwickeln Sie internationale Kontakte', 'Arbeiten Sie mit NGOs zusammen'],
                'gold' => ['Bauen Sie ein Netzwerk auf', 'Werden Sie Impulsgeber für andere Schulen']
            ],
            'ressourcen-infrastruktur' => [
                'bronze' => ['Implementieren Sie Energiesparmaßnahmen', 'Trennen Sie Abfälle konsequent'],
                'silver' => ['Entwickeln Sie eine nachhaltige Beschaffungspolitik', 'Nutzen Sie erneuerbare Energien'],
                'gold' => ['Streben Sie nach höchster Energieeffizienz', 'Werden Sie CO2-neutral']
            ],
            'qualitaetsentwicklung' => [
                'bronze' => ['Führen Sie regelmäßige Evaluationen durch', 'Definieren Sie Qualitätsstandards'],
                'silver' => ['Entwickeln Sie ein Qualitätsmanagementsystem', 'Nutzen Sie Feedbackschleifen'],
                'gold' => ['Wenden Sie Benchmarking an', 'Teilen Sie Best Practices']
            ]
        ];

        return $recommendations[$categorySlug][$level] ?? [];
    }

    /**
     * Ressourcen basierend auf dem Status
     */
    private function getResources($status)
    {
        $resources = [
            'bronze' => [
                [
                    'title' => 'Einstieg in die Bildung für nachhaltige Entwicklung',
                    'description' => 'Grundlagen und erste Schritte für Schulen',
                    'type' => 'Leitfaden',
                    'url' => '#'
                ],
                [
                    'title' => 'Nachhaltigkeits-Checkliste für Schulen',
                    'description' => 'Praktische Hilfen für den Einstieg',
                    'type' => 'Tool',
                    'url' => '#'
                ]
            ],
            'silver' => [
                [
                    'title' => 'Umfassendes Nachhaltigkeitsmanagement',
                    'description' => 'Fortgeschrittene Strategien und Methoden',
                    'type' => 'Handbuch',
                    'url' => '#'
                ],
                [
                    'title' => 'Best Practice Beispiele',
                    'description' => 'Erfolgreiche Nachhaltigkeitsprojekte anderer Schulen',
                    'type' => 'Fallstudien',
                    'url' => '#'
                ]
            ],
            'gold' => [
                [
                    'title' => 'Exzellenz in der Nachhaltigkeitsbildung',
                    'description' => 'Innovative Ansätze und Zertifizierungsmöglichkeiten',
                    'type' => 'Expertenwissen',
                    'url' => '#'
                ],
                [
                    'title' => 'Netzwerk für nachhaltige Schulen',
                    'description' => 'Austausch mit anderen Spitzenreitern',
                    'type' => 'Community',
                    'url' => '#'
                ]
            ]
        ];

        return $resources[$status] ?? $resources['bronze'];
    }

    /**
     * Zeige Gast-Ergebnisse
     */
    public function showGuest()
    {
        $guestResult = session('guest_result');

        if (!$guestResult) {
            return redirect('/')->with('error', 'Keine Gast-Ergebnisse gefunden. Bitte starten Sie den Fragebogen erneut.');
        }

        $categories = Category::all();

        // Verbesserungsvorschläge basierend auf dem Status
        $recommendations = $this->getGuestRecommendations($guestResult);

        // Ressourcen basierend auf dem Status
        $resources = $this->getResources($guestResult['status']);

        return view('results.show', [
            'result' => $guestResult,
            'user' => null,
            'categories' => $categories,
            'recommendations' => $recommendations,
            'resources' => $resources,
            'is_guest' => true
        ]);
    }

    /**
     * Generiere Verbesserungsvorschläge für Gäste basierend auf dem Status
     */
    private function getGuestRecommendations($guestResult)
    {
        $recommendations = [];

        switch ($guestResult['status']) {
            case 'bronze':
                $recommendations = $this->getBronzeRecommendationsForGuest($guestResult);
                break;
            case 'silver':
                $recommendations = $this->getSilverRecommendationsForGuest($guestResult);
                break;
            case 'gold':
                $recommendations = $this->getGoldRecommendationsForGuest($guestResult);
                break;
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Bronze-Status (Gast-Version)
     */
    private function getBronzeRecommendationsForGuest($guestResult)
    {
        $recommendations = [
            'general' => [
                'Erstellen Sie eine schriftliche Nachhaltigkeitsstrategie für Ihre Schule',
                'Benennen Sie eine verantwortliche Person für Nachhaltigkeitsthemen',
                'Integrieren Sie Nachhaltigkeit in die Schulordnung',
                'Planen Sie ein Budget für Nachhaltigkeitsprojekte ein'
            ]
        ];

        // Kategoriespezifische Empfehlungen
        if (isset($guestResult['category_scores'])) {
            foreach ($guestResult['category_scores'] as $categorySlug => $scores) {
                if ($scores['percentage'] < 50) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'bronze');
                }
            }
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Silber-Status (Gast-Version)
     */
    private function getSilverRecommendationsForGuest($guestResult)
    {
        $recommendations = [
            'general' => [
                'Entwickeln Sie ein umfassendes Qualitätsmanagementsystem',
                'Bauen Sie Partnerschaften mit externen Organisationen aus',
                'Führen Sie regelmäßige Fortbildungen durch',
                'Implementieren Sie ein Energiemanagementsystem'
            ]
        ];

        // Kategoriespezifische Empfehlungen
        if (isset($guestResult['category_scores'])) {
            foreach ($guestResult['category_scores'] as $categorySlug => $scores) {
                if ($scores['percentage'] < 70) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'silver');
                }
            }
        }

        return $recommendations;
    }

    /**
     * Empfehlungen für Gold-Status (Gast-Version)
     */
    private function getGoldRecommendationsForGuest($guestResult)
    {
        $recommendations = [
            'general' => [
                'Streben Sie Zertifizierungen an (z.B. Öko-Schule, Energieeffizienz)',
                'Bauen Sie ein Netzwerk mit anderen nachhaltigen Schulen auf',
                'Entwickeln Sie sich zu einem Vorbild in der Region',
                'Teilen Sie Ihre Erfahrungen und Materialien mit anderen Schulen'
            ]
        ];

        // Kategoriespezifische Empfehlungen für höchste Exzellenz
        if (isset($guestResult['category_scores'])) {
            foreach ($guestResult['category_scores'] as $categorySlug => $scores) {
                if ($scores['percentage'] < 90) {
                    $recommendations['categories'][$categorySlug] = $this->getCategoryRecommendations($categorySlug, 'gold');
                }
            }
        }

        return $recommendations;
    }
}
