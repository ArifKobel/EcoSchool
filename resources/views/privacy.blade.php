<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Datenschutzerklärung') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <div class="prose dark:prose-invert max-w-none">

                        <h1>Datenschutzerklärung für die BBNE-Selbsteinschätzung</h1>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Stand: {{ date('d.m.Y') }}
                        </p>

                        <h2>1. Verantwortlicher</h2>
                        <p>
                            Verantwortlich für die Verarbeitung personenbezogener Daten im Rahmen dieser Web-Anwendung ist:<br>
                            [Name der Institution]<br>
                            [Adresse]<br>
                            [E-Mail]<br>
                            [Telefon]
                        </p>

                        <h2>2. Zweck der Datenverarbeitung</h2>
                        <p>
                            Diese Web-Anwendung dient der Selbsteinschätzung von Schulen im Bereich "Berufliche Bildung für nachhaltige Entwicklung" (BBNE).
                            Die Datenverarbeitung erfolgt ausschließlich zu diesem Zweck.
                        </p>

                        <h2>3. Erhobene Daten</h2>

                        <h3>3.1 Pflichtangaben bei der Registrierung</h3>
                        <ul>
                            <li>E-Mail-Adresse (für Authentifizierung und Kommunikation)</li>
                            <li>Passwort (verschlüsselt gespeichert)</li>
                        </ul>

                        <h3>3.2 Freiwillige Angaben</h3>
                        <ul>
                            <li>Schulname (optional)</li>
                            <li>Schulart (optional)</li>
                            <li>Standort der Schule (optional)</li>
                            <li>Rolle des Users (optional)</li>
                        </ul>

                        <h3>3.3 Automatisch erfasste Daten</h3>
                        <ul>
                            <li>Antworten auf den Selbsteinschätzungsfragebogen</li>
                            <li>Berechnete Ergebnisse und Status (Bronze/Silber/Gold)</li>
                            <li>Zeitstempel der Antworten und des Abschlusses</li>
                            <li>IP-Adresse (nur temporär für Sicherheit)</li>
                        </ul>

                        <h2>4. Rechtsgrundlage</h2>
                        <p>
                            Die Verarbeitung Ihrer Daten erfolgt auf Grundlage Ihrer ausdrücklichen Einwilligung (Art. 6 Abs. 1 lit. a DSGVO)
                            sowie zur Erfüllung des Vertrags über die Nutzung dieser Anwendung (Art. 6 Abs. 1 lit. b DSGVO).
                        </p>

                        <h2>5. Speicherdauer</h2>
                        <ul>
                            <li><strong>Konto- und Profildaten:</strong> Werden gespeichert, solange Ihr Konto aktiv ist</li>
                            <li><strong>Fragebogenantworten:</strong> Werden für die Dauer Ihres aktiven Kontos gespeichert</li>
                            <li><strong>Ergebnisse:</strong> Werden dauerhaft gespeichert, um Entwicklung zu dokumentieren</li>
                            <li><strong>Gelöschte Konten:</strong> Alle Daten werden innerhalb von 30 Tagen nach Kontolöschung entfernt</li>
                        </ul>

                        <h2>6. Anonyme Nutzung</h2>
                        <p>
                            Sie haben die Möglichkeit, die Anwendung anonym zu nutzen. In diesem Fall werden keine personenbezogenen Daten
                            erhoben oder gespeichert. Die Ergebnisse werden nur temporär zur Anzeige verwendet und nicht dauerhaft gespeichert.
                        </p>

                        <h2>7. Ihre Rechte</h2>

                        <p>Sie haben folgende Rechte bezüglich Ihrer personenbezogenen Daten:</p>

                        <ul>
                            <li><strong>Auskunftsrecht (Art. 15 DSGVO):</strong> Sie können Auskunft über die zu Ihrer Person gespeicherten Daten verlangen</li>
                            <li><strong>Berichtigungsrecht (Art. 16 DSGVO):</strong> Sie können unrichtige Daten berichtigen lassen</li>
                            <li><strong>Löschungsrecht (Art. 17 DSGVO):</strong> Sie können die Löschung Ihrer Daten verlangen</li>
                            <li><strong>Recht auf Einschränkung der Verarbeitung (Art. 18 DSGVO):</strong> Sie können die Verarbeitung einschränken lassen</li>
                            <li><strong>Widerspruchsrecht (Art. 21 DSGVO):</strong> Sie können der Verarbeitung widersprechen</li>
                            <li><strong>Recht auf Datenübertragbarkeit (Art. 20 DSGVO):</strong> Sie können Ihre Daten in einem strukturierten Format erhalten</li>
                        </ul>

                        <h2>8. Datensicherheit</h2>
                        <p>
                            Wir setzen technische und organisatorische Maßnahmen ein, um Ihre Daten vor unbefugtem Zugriff,
                            Verlust oder Manipulation zu schützen. Dazu gehören:
                        </p>
                        <ul>
                            <li>Verschlüsselte Datenübertragung (HTTPS)</li>
                            <li>Verschlüsselte Datenspeicherung</li>
                            <li>Regelmäßige Sicherheitsupdates</li>
                            <li>Zugriffsbeschränkungen</li>
                        </ul>

                        <h2>9. Cookies</h2>
                        <p>
                            Diese Anwendung verwendet nur technisch notwendige Cookies für die Authentifizierung und Session-Verwaltung.
                            Es werden keine Tracking-Cookies oder Analyse-Tools verwendet.
                        </p>

                        <h2>10. Kontakt</h2>
                        <p>
                            Bei Fragen zum Datenschutz oder zur Ausübung Ihrer Rechte wenden Sie sich bitte an:<br>
                            [Datenschutzbeauftragter]<br>
                            E-Mail: [E-Mail-Adresse]<br>
                            Telefon: [Telefonnummer]
                        </p>

                        <h2>11. Änderungen dieser Datenschutzerklärung</h2>
                        <p>
                            Wir behalten uns vor, diese Datenschutzerklärung anzupassen, wenn dies aufgrund gesetzlicher Änderungen
                            oder technischer Entwicklungen notwendig wird. Über wesentliche Änderungen werden wir Sie informieren.
                        </p>

                        <hr class="my-8">

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">Ihre Einwilligung</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                                Mit der Nutzung dieser Anwendung erklären Sie sich mit der beschriebenen Datenverarbeitung einverstanden.
                                Ihre Einwilligung können Sie jederzeit mit Wirkung für die Zukunft widerrufen.
                            </p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">
                                Diese Datenschutzerklärung wurde mit größter Sorgfalt erstellt. Für die Richtigkeit und Vollständigkeit
                                kann jedoch keine Gewähr übernommen werden.
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
