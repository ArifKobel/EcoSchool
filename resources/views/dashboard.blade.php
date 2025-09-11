<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BBNE Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h1 class="ml-3 text-2xl font-medium text-gray-900">
                            Willkommen bei der BBNE-Selbsteinschätzung
                        </h1>
                    </div>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        Die Berufliche Bildung für nachhaltige Entwicklung (BBNE) hilft Schulen dabei, ihren aktuellen Stand der Nachhaltigkeitsorientierung zu bewerten und Entwicklungsmöglichkeiten aufzuzeigen.
                    </p>
                </div>
            </div>

            @php
                $user = auth()->user();
                $hasCompleted = $user->hasCompletedQuestionnaire();
                $progress = $user->getProgressPercentage();
            @endphp

            @if(!$hasCompleted)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Ihr Fragebogen-Status
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Arbeiten Sie den Fragebogen durch, um Ihre Ergebnisse zu erhalten
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $progress }}%</div>
                                <div class="text-sm text-gray-500">abgeschlossen</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('questionnaire.show') }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                @if($progress > 0)
                                    Fragebogen fortsetzen
                                @else
                                    Fragebogen starten
                                @endif
                            </a>

                            @if($progress > 0)
                                <span class="text-sm text-gray-500 self-center">
                                    Sie haben bereits {{ $user->answers()->count() }} Fragen beantwortet
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Was erwartet Sie?
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h4 class="mt-2 text-sm font-medium text-gray-900">100 Fragen</h4>
                                <p class="mt-1 text-xs text-gray-500">Umfassende Selbsteinschätzung</p>
                            </div>

                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h4 class="mt-2 text-sm font-medium text-gray-900">6 Handlungsfelder</h4>
                                <p class="mt-1 text-xs text-gray-500">Whole School Approach</p>
                            </div>

                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <h4 class="mt-2 text-sm font-medium text-gray-900">3 Status-Levels</h4>
                                <p class="mt-1 text-xs text-gray-500">Bronze, Silber, Gold</p>
                            </div>

                            <div class="text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="mt-2 text-sm font-medium text-gray-900">Konkrete Empfehlungen</h4>
                                <p class="mt-1 text-xs text-gray-500">Für Ihre Entwicklung</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php
                    $result = $user->finalResult;
                @endphp

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">
                                    Ihre Ergebnisse
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Herzlichen Glückwunsch! Sie haben den Fragebogen abgeschlossen.
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold
                                           @if($result->status === 'gold') text-yellow-600
                                           @elseif($result->status === 'silver') text-gray-600
                                           @else text-amber-600 @endif">
                                    {{ $result->getStatusName() }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $result->total_points }} Punkte</div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('results.show', $result) }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Ergebnisse ansehen
                            </a>

                            <a href="{{ route('questionnaire.show') }}"
                               class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Fragebogen wiederholen
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Schnellübersicht Ihrer Handlungsfelder
                        </h3>

                        <div class="space-y-3">
                            @php
                                $categories = \App\Models\Category::all();
                            @endphp
                            @foreach($categories as $category)
                                @php
                                    $categoryScore = $result->category_scores[$category->slug] ?? ['percentage' => 0];
                                @endphp
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $categoryScore['percentage'] }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 w-12 text-right">{{ $categoryScore['percentage'] }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
