<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>EcoSchool</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col overflow-x-hidden text-[#1b1b18] dark:text-[#EDEDEC]">
        <!-- Background Layers -->
        <div class="fixed inset-0 -z-20">
            <!-- Subtle radial gradient mesh -->
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-50 via-white to-emerald-50 dark:from-[#0b0f0b] dark:via-[#0a0a0a] dark:to-[#0b0f0b]"></div>
            <div class="absolute inset-0 opacity-60 dark:opacity-40 [background:radial-gradient(60%_60%_at_80%_10%,rgba(16,185,129,0.20)_0%,rgba(16,185,129,0)_60%),radial-gradient(50%_50%_at_0%_100%,rgba(163,230,53,0.18)_0%,rgba(163,230,53,0)_55%)]"></div>
            <!-- Fine grid with radial mask -->
            <div class="absolute inset-0 pointer-events-none [background:linear-gradient(to_right,rgba(0,0,0,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(0,0,0,0.04)_1px,transparent_1px)] [background-size:28px_28px] [mask-image:radial-gradient(ellipse_at_center,black,transparent_70%)] dark:[background:linear-gradient(to_right,rgba(255,255,255,0.06)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.06)_1px,transparent_1px)]"></div>
        </div>

        <!-- Header -->
        <header class="w-full sticky top-0 z-30">
            <div class="backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-black/20 border-b border-black/5 dark:border-white/10">
                <div class="mx-auto max-w-7xl px-6 py-4">
                    <div class="flex items-center justify-between">
                        <a href="/" class="flex items-center gap-2">
                            <x-application-logo class="w-9 h-9" />
                            <span class="font-semibold tracking-tight">EcoSchool</span>
                        </a>

                        @if (Route::has('login'))
                            <nav class="flex items-center gap-2 md:gap-3">
                                <a href="#features" class="hidden md:inline-block px-4 py-2 text-sm rounded-md border border-black/10 dark:border-white/15 hover:border-black/20 dark:hover:border-white/25">Funktionen</a>
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-md bg-emerald-600 text-white px-4 py-2 text-sm font-medium shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                        Zum Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm rounded-md border border-transparent hover:border-black/10 dark:hover:border-white/15">Anmelden</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md bg-gradient-to-tr from-emerald-600 to-lime-500 text-white px-4 py-2 text-sm font-medium shadow-sm hover:from-emerald-700 hover:to-lime-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                            Jetzt starten
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative overflow-hidden">
            <!-- Accent glows -->
            <div class="absolute inset-0 -z-10 opacity-70">
                <div class="absolute -top-24 -right-16 h-64 w-64 rounded-full bg-emerald-400/40 blur-3xl"></div>
                <div class="absolute top-40 -left-24 h-72 w-72 rounded-full bg-lime-400/40 blur-3xl"></div>
            </div>

            <div class="mx-auto max-w-7xl px-6 py-12 md:py-18 lg:py-24">
                <div class="grid items-center gap-12 md:grid-cols-12">
                    <div class="md:col-span-7">
                        <div class="inline-flex items-center gap-2 rounded-full border border-black/10 dark:border-white/10 bg-white/70 dark:bg-white/5 px-3 py-1.5 backdrop-blur">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-black/60 dark:text-white/70">BBNE für Schulen – praxisnah</span>
                        </div>
                        <h1 class="mt-4 text-3xl md:text-5xl font-semibold tracking-tight leading-tight">
                            BBNE‑Selbsteinschätzung – schnell, verständlich, wirkungsvoll.
                        </h1>
                        <p class="mt-4 text-base md:text-lg text-black/70 dark:text-white/70 max-w-2xl">
                            Erfassen Sie den Status Ihrer Schule in der Berufsbildung für nachhaltige Entwicklung, erhalten Sie eine klare Einstufung (Bronze/Silber/Gold) und erkennen Sie, wo Sie gezielt nachbessern können.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-md bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                    Bewertung fortsetzen
                                </a>
                            @else
                                <a href="{{ route('guest.questionnaire.show') }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400/70">
                                    Anonym testen
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md bg-gradient-to-tr from-emerald-600 to-lime-500 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:from-emerald-700 hover:to-lime-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                        Jetzt registrieren
                                    </a>
                                @endif
                            @endauth
                        </div>
                        <div class="mt-6 flex items-center gap-5 text-xs text-black/60 dark:text-white/60">
                            <div class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Datenschutzfreundlich</div>
                            <div class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Kostenlos starten</div>
                            <div class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Ohne Installation</div>
                        </div>
                    </div>

                    <div class="md:col-span-5">
                        <div class="relative">
                            <!-- Decorative card stack -->
                            <div class="absolute -inset-6 -z-10 rounded-3xl bg-gradient-to-tr from-emerald-500/20 via-lime-400/20 to-transparent blur-2xl"></div>
                            <div class="rounded-2xl border border-black/10 dark:border-white/10 bg-white/70 dark:bg-white/5 backdrop-blur p-6 shadow-sm">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-xl p-4 border border-black/10 dark:border-white/10 bg-white/80 dark:bg-white/5">
                                        <p class="text-xs text-black/60 dark:text-white/60">Einstufung</p>
                                        <p class="mt-1 text-lg font-semibold">Silber</p>
                                        <div class="mt-3 h-2 w-full rounded-full bg-black/10 dark:bg-white/10">
                                            <div class="h-2 w-2/3 rounded-full bg-gradient-to-r from-emerald-500 to-lime-400"></div>
                                        </div>
                                    </div>
                                    <div class="rounded-xl p-4 border border-black/10 dark:border-white/10 bg-white/80 dark:bg-white/5">
                                        <p class="text-xs text-black/60 dark:text-white/60">Fortschritt</p>
                                        <p class="mt-1 text-lg font-semibold">67%</p>
                                        <div class="mt-3 flex -space-x-2">
                                            <span class="h-6 w-6 rounded-full bg-emerald-500/20 border border-emerald-500/30"></span>
                                            <span class="h-6 w-6 rounded-full bg-lime-500/20 border border-lime-500/30"></span>
                                            <span class="h-6 w-6 rounded-full bg-blue-500/20 border border-blue-500/30"></span>
                                        </div>
                                    </div>
                                    <div class="col-span-2 rounded-xl p-4 border border-black/10 dark:border-white/10 bg-white/80 dark:bg-white/5">
                                        <p class="text-xs text-black/60 dark:text-white/60">Nächster Schritt</p>
                                        <p class="mt-1">Handlungsfelder priorisieren und Maßnahmen planen.</p>
                                        <div class="mt-3 flex items-center gap-2 text-xs text-emerald-700 dark:text-emerald-300">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>Empfehlung generiert
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="relative">
            <div class="mx-auto max-w-7xl px-6 py-12 md:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight">Warum EcoSchool?</h2>
                    <p class="mt-2 text-black/70 dark:text-white/70">Klar strukturierte Selbsteinschätzung, aussagekräftige Auswertung und konkrete Handlungsempfehlungen.</p>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-5 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75S6.615 21.75 12 21.75 21.75 17.385 21.75 12 17.385 2.25 12 2.25ZM7.5 9.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75Zm0 4.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"/></svg>
                        </div>
                        <p class="font-medium">Intuitiv und zeitsparend</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Fragen klar gegliedert nach Handlungsfeldern – effizient durchführbar.</p>
                    </div>

                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-5 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M11.25 3a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3.75A.75.75 0 0 1 11.25 3Z"/></svg>
                        </div>
                        <p class="font-medium">Klare Ergebnisse</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Bronze/Silber/Gold mit verständlicher Visualisierung und Exportoption.</p>
                    </div>

                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-5 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M3 4.5A1.5 1.5 0 0 1 4.5 3h15A1.5 1.5 0 0 1 21 4.5v12a1.5 1.5 0 0 1-1.5 1.5H14.5l-3.25 2.6a.75.75 0 0 1-1.2-.6V18H4.5A1.5 1.5 0 0 1 3 16.5v-12Z"/></svg>
                        </div>
                        <p class="font-medium">Gemeinsam im Team</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Kollegial zusammenarbeiten, vergleichen und Maßnahmen abstimmen.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="relative border-t border-black/5 dark:border-white/10">
            <div class="mx-auto max-w-7xl px-6 py-12 md:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight">So funktioniert’s</h2>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-6 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 1</div>
                        <p class="font-medium">Als Gast starten oder registrieren</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Testen Sie als Gast – oder registrieren Sie sich für dauerhafte Speicherung.</p>
                    </div>
                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-6 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 2</div>
                        <p class="font-medium">Fragebogen ausfüllen</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Unterricht, Schulentwicklung, Kooperationen und mehr – klar strukturiert.</p>
                    </div>
                    <div class="rounded-xl border border-black/10 dark:border-white/10 p-6 bg-white/70 dark:bg-white/5 backdrop-blur">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 3</div>
                        <p class="font-medium">Ergebnis erhalten</p>
                        <p class="mt-1 text-sm text-black/70 dark:text-white/70">Status (Bronze/Silber/Gold) plus Detailauswertung und Empfehlungen.</p>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    @auth
                        <a href="{{ url('/questionnaire') }}" class="inline-flex items-center gap-2 rounded-md bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                            Fragebogen öffnen
                        </a>
                    @else
                        <a href="{{ route('guest.questionnaire.show') }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400/70 mr-3">
                            Anonym testen
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md bg-gradient-to-tr from-emerald-600 to-lime-500 text-white px-5 py-2.5 text-sm font-medium shadow-sm hover:from-emerald-700 hover:to-lime-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                Jetzt kostenlos starten
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-auto border-t border-black/5 dark:border-white/10">
            <div class="mx-auto max-w-7xl px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-black/70 dark:text-white/70">
                <p>© {{ date('Y') }} EcoSchool. Alle Rechte vorbehalten.</p>
                <div class="flex items-center gap-5">
                    <a href="{{ route('privacy') }}" class="hover:text-black dark:hover:text-white">Datenschutz</a>
                    <a href="#features" class="hover:text-black dark:hover:text-white">Funktionen</a>
                </div>
            </div>
        </footer>
    </body>
    </html>
