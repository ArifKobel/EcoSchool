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
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full">
            <div class="mx-auto max-w-7xl px-6 py-5">
                <div class="flex items-center justify-between">
                    <a href="/" class="flex items-center gap-2">
                        <x-application-logo class="w-9 h-9" />
                        <span class="font-semibold tracking-tight">EcoSchool</span>
                    </a>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-4 py-2 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                    Zum Dashboard
                                </a>
                            @else
                                <a href="#features" class="hidden md:inline-block px-4 py-2 text-sm rounded-md border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b]">Funktionen</a>
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm rounded-md border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A]">Anmelden</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-4 py-2 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                        Jetzt starten
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative isolate overflow-hidden">
            <div class="absolute inset-0 -z-10 opacity-[0.08] dark:opacity-[0.12]">
                <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-emerald-400 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-lime-400 blur-3xl"></div>
            </div>

            <div class="mx-auto max-w-7xl px-6 py-10 md:py-16 lg:py-24">
                <div class="grid items-center gap-10 md:grid-cols-12">
                    <div class="md:col-span-7 lg:col-span-7">
                        <h1 class="text-3xl md:text-5xl font-semibold tracking-tight leading-tight">
                            BBNE-Selbsteinschätzung für Schulen – schnell, verständlich, wirkungsvoll.
                        </h1>
                        <p class="mt-4 text-base md:text-lg text-[#3a3a34] dark:text-[#c8c8c6] max-w-2xl">
                            Erfassen Sie den Status Ihrer Schule in der Berufsbildung für nachhaltige Entwicklung, erhalten Sie eine klare Einstufung (Bronze/Silber/Gold) und sehen Sie, wo Sie gezielt nachbessern können.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                    Bewertung fortsetzen
                                </a>
                            @else
                                <a href="{{ route('guest.questionnaire.show') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-blue-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400/70">
                                    Anonym testen
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                        Kostenlos starten
                                    </a>
                                @endif
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-md border border-[#19140035] dark:border-[#3E3E3A] px-5 py-2.5 text-sm font-medium hover:border-[#1915014a] dark:hover:border-[#62605b]">
                                    Ich habe bereits ein Konto
                                </a>
                            @endauth
                        </div>
                        <div class="mt-6 flex items-center gap-4 text-xs text-[#4a4a44] dark:text-[#b9b9b7]">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <x-tabler-cookie class="h-3.5 w-3.5" />
                                </span>
                                <span>Kein Tracking, nur notwendige Cookies</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    <x-heroicon-o-star class="h-3.5 w-3.5" />
                                </span>
                                <span>Ergebnis als Bronze/Silber/Gold</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 lg:col-span-5">
                        <div class="relative mx-auto max-w-md md:max-w-none">
                            <div class="aspect-[4/3] rounded-xl border border-[#19140035] dark:border-[#3E3E3A] bg-white/70 dark:bg-white/5 shadow-sm overflow-hidden">
                                <div class="h-full w-full grid place-items-center p-6">
                                    <div class="text-center">
                                        <div class="mx-auto mb-4 h-14 w-14 rounded-xl bg-emerald-600/90 text-white grid place-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7"><path d="M12.53 2.16a.75.75 0 0 0-1.06 0L3.2 10.44a.75.75 0 0 0 .53 1.28h2.63v7.53c0 .41.34.75.75.75h3.75v-5.25h3v5.25h3.75c.41 0 .75-.34.75-.75v-7.53h2.63a.75.75 0 0 0 .53-1.28L12.53 2.16Z"/></svg>
                                        </div>
                                        <p class="text-base md:text-lg font-medium">Übersichtliches Dashboard</p>
                                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Behalten Sie Fortschritt und Maßnahmen im Blick.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="border-t border-[#19140020] dark:border-[#3E3E3A]">
            <div class="mx-auto max-w-7xl px-6 py-12 md:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight">Warum EcoSchool?</h2>
                    <p class="mt-3 text-[#3a3a34] dark:text-[#c8c8c6]">Praktische Selbsteinschätzung mit klaren Ergebnissen und Fokus auf Verbesserung.</p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M4.5 3.75A.75.75 0 0 1 5.25 3h13.5a.75.75 0 0 1 .75.75v16.5a.75.75 0 0 1-1.03.69l-5.97-2.39-5.97 2.39a.75.75 0 0 1-1.03-.69V3.75Z"/></svg>
                        </div>
                        <p class="font-medium">Schnelle Selbsteinschätzung</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Beantworten Sie strukturierte Fragen – fertig in wenigen Minuten.</p>
                    </div>

                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 6.97a.75.75 0 0 1 0 1.06l-5.25 5.25a.75.75 0 0 1-1.06 0L7.72 13.28a.75.75 0 0 1 1.06-1.06l1.69 1.69 4.72-4.72a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="font-medium">Klare Bewertung</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Einstufung in Bronze, Silber oder Gold – jederzeit nachvollziehbar.</p>
                    </div>

                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M3.75 4.5A.75.75 0 0 1 4.5 3.75h15a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-.75.75H4.5a.75.75 0 0 1-.75-.75V4.5Zm0 7.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-.75.75H4.5a.75.75 0 0 1-.75-.75v-7.5Zm12 0a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-7.5Z"/></svg>
                        </div>
                        <p class="font-medium">Fokus auf Handlungsfelder</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Erkennen Sie Stärken und Entwicklungsbereiche auf einen Blick.</p>
                    </div>

                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M11.25 3a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3.75A.75.75 0 0 1 11.25 3Z"/></svg>
                        </div>
                        <p class="font-medium">Einfacher Export</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Teilen Sie Ergebnisse mit Kollegium und Schulleitung.</p>
                    </div>

                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M3 4.5A1.5 1.5 0 0 1 4.5 3h15A1.5 1.5 0 0 1 21 4.5v12a1.5 1.5 0 0 1-1.5 1.5H14.5l-3.25 2.6a.75.75 0 0 1-1.2-.6V18H4.5A1.5 1.5 0 0 1 3 16.5v-12Z"/></svg>
                        </div>
                        <p class="font-medium">Teamfähig</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Arbeiten Sie gemeinsam am Fragebogen und vergleichen Sie Stände.</p>
                    </div>

                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 bg-white/60 dark:bg-white/5">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75S6.615 21.75 12 21.75 21.75 17.385 21.75 12 17.385 2.25 12 2.25ZM7.5 9.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75Zm0 4.5a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"/></svg>
                        </div>
                        <p class="font-medium">Datenschutzfreundlich</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Nur notwendige Cookies. <a href="{{ route('privacy') }}" class="underline underline-offset-4 hover:no-underline">Mehr erfahren</a>.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="border-t border-[#19140020] dark:border-[#3E3E3A] bg-white/40 dark:bg-white/5">
            <div class="mx-auto max-w-7xl px-6 py-12 md:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-2xl md:text-3xl font-semibold tracking-tight">So funktioniert’s</h2>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-6 bg-white/70 dark:bg-white/5">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 1</div>
                        <p class="font-medium">Anonym starten oder registrieren</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Testen Sie den Fragebogen anonym – oder registrieren Sie sich für dauerhafte Speicherung.</p>
                    </div>
                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-6 bg-white/70 dark:bg-white/5">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 2</div>
                        <p class="font-medium">Fragebogen ausfüllen</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Beantworten Sie Fragen zu Unterricht, Schulentwicklung, Kooperationen und mehr.</p>
                    </div>
                    <div class="rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-6 bg-white/70 dark:bg-white/5">
                        <div class="mb-4 text-sm font-medium text-emerald-700 dark:text-emerald-300">Schritt 3</div>
                        <p class="font-medium">Ergebnis erhalten</p>
                        <p class="mt-1 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">Sehen Sie Ihren Status (Bronze/Silber/Gold) inklusive Detailauswertung.</p>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    @auth
                        <a href="{{ url('/questionnaire') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                            Fragebogen öffnen
                        </a>
                    @else
                        <a href="{{ route('guest.questionnaire.show') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-blue-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400/70 mr-3">
                            Anonym testen
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-md border border-transparent bg-emerald-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-400/70">
                                Jetzt kostenlos starten
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-auto border-t border-[#19140020] dark:border-[#3E3E3A]">
            <div class="mx-auto max-w-7xl px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-[#4a4a44] dark:text-[#b9b9b7]">
                <p>© {{ date('Y') }} EcoSchool. Alle Rechte vorbehalten.</p>
                <div class="flex items-center gap-5">
                    <a href="{{ route('privacy') }}" class="hover:text-[#1b1b18] dark:hover:text-white">Datenschutz</a>
                    <a href="#features" class="hover:text-[#1b1b18] dark:hover:text-white">Funktionen</a>
                </div>
            </div>
        </footer>
    </body>
</html>
