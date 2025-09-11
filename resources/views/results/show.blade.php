<x-app-layout class="results-page">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($is_guest) && $is_guest)
                {{ __('Ihre BBNE-Ergebnisse') }}
            @else
                {{ __('Ihre BBNE-Ergebnisse') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(isset($is_guest) && $is_guest)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Hinweis:</strong> Sie haben den Fragebogen als Gast durchgeführt. Diese Ergebnisse werden nicht gespeichert.
                                @if(Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-medium underline text-blue-700 hover:text-blue-600">Registrieren Sie sich</a>, um Ihre Ergebnisse dauerhaft zu speichern.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg result-summary no-break">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="text-center">
                        @php
                            $resultStatus = is_object($result) ? $result->status : $result['status'];
                            $totalPoints = is_object($result) ? $result->total_points : $result['total_points'];
                            $maxPoints = is_object($result) ? $result->max_points : $result['max_points'];
                            $percentage = is_object($result) ? $result->percentage : $result['percentage'];
                            $statusName = is_object($result) ? $result->getStatusName() : ucfirst($result['status']);
                        @endphp

                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full
                                    @if($resultStatus === 'gold') bg-yellow-100
                                    @elseif($resultStatus === 'silver') bg-gray-100
                                    @else bg-amber-100 @endif mb-4">
                            <span class="text-2xl font-bold
                                       @if($resultStatus === 'gold') text-yellow-600
                                       @elseif($resultStatus === 'silver') text-gray-600
                                       @else text-amber-600 @endif">
                                {{ $totalPoints }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-2" id="result-heading">
                            {{ $statusName }}-Status
                        </h1>

                        <p class="text-lg text-gray-600 mb-4">
                            {{ $percentage }}% erreicht ({{ $totalPoints }} von {{ $maxPoints }} Punkten)
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                            <div class="h-3 rounded-full transition-all duration-500
                                        @if($resultStatus === 'gold') bg-yellow-500
                                        @elseif($resultStatus === 'silver') bg-gray-500
                                        @else bg-amber-500 @endif"
                                 style="width: {{ $percentage }}%"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalPoints }}</div>
                                <div class="text-sm text-green-600 dark:text-green-400">Ihre Punkte</div>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $maxPoints }}</div>
                                <div class="text-sm text-blue-600 dark:text-blue-400">Maximale Punkte</div>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $percentage }}%</div>
                                <div class="text-sm text-purple-600 dark:text-purple-400">Erreichter Score</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg category-breakdown no-break">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        Aufschlüsselung nach Handlungsfeldern
                    </h3>

                    <div class="space-y-4">
                        @foreach($categories as $category)
                            @php
                                $categoryScores = is_object($result) ? $result->category_scores : $result['category_scores'];
                                $categoryScore = $categoryScores[$category->slug] ?? ['points' => 0, 'max_points' => 0, 'percentage' => 0];
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">
                                        {{ $category->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $categoryScore['points'] }} von {{ $categoryScore['max_points'] }} Punkten
                                    </p>
                                </div>
                                <div class="ml-4 flex items-center space-x-4">
                                    <div class="text-right">
                                        <div class="text-lg font-semibold text-gray-900">
                                            {{ $categoryScore['percentage'] }}%
                                        </div>
                                        <div class="w-24 bg-gray-200 rounded-full h-2"
                                             role="progressbar"
                                             aria-valuenow="{{ $categoryScore['percentage'] }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             aria-label="Ergebnis für {{ $category->name }}">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                                                 style="width: {{ $categoryScore['percentage'] }}%"
                                                 aria-hidden="true"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if(!empty($recommendations))
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg recommendations-section">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">
                            Ihre nächsten Schritte
                        </h3>

                        @if(isset($recommendations['general']) && !empty($recommendations['general']))
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Allgemeine Empfehlungen</h4>
                                <ul class="space-y-2">
                                    @foreach($recommendations['general'] as $recommendation)
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $recommendation }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($recommendations['categories']) && !empty($recommendations['categories']))
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Handlungsfeld-spezifische Empfehlungen</h4>
                                @foreach($recommendations['categories'] as $categorySlug => $categoryRecs)
                                    @php
                                        $category = $categories->where('slug', $categorySlug)->first();
                                    @endphp
                                    @if($category && !empty($categoryRecs))
                                        <div class="mb-4">
                                            <h5 class="font-medium text-gray-800 dark:text-gray-200 mb-2">{{ $category->name }}</h5>
                                            <ul class="ml-4 space-y-1">
                                                @foreach($categoryRecs as $rec)
                                                    <li class="flex items-start text-sm">
                                                        <svg class="h-4 w-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                        </svg>
                                                        <span class="text-gray-600 dark:text-gray-400">{{ $rec }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(!empty($resources))
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg resources-section">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">
                            Empfohlene Ressourcen
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($resources as $resource)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 mb-1">
                                                {{ $resource['title'] }}
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-2">
                                                {{ $resource['description'] }}
                                            </p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                       @if($resource['type'] === 'Leitfaden') bg-blue-100 text-blue-800
                                                       @elseif($resource['type'] === 'Handbuch') bg-green-100 text-green-800
                                                       @elseif($resource['type'] === 'Fallstudien') bg-purple-100 text-purple-800
                                                       @elseif($resource['type'] === 'Expertenwissen') bg-yellow-100 text-yellow-800
                                                       @else bg-gray-100 text-gray-800 @endif">
                                                {{ $resource['type'] }}
                                            </span>
                                        </div>
                                        <a href="{{ $resource['url'] }}" target="_blank"
                                           class="ml-4 text-blue-600 hover:text-blue-800">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg print:hidden">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <form method="POST" action="{{ (isset($is_guest) && $is_guest) ? route('guest.questionnaire.reset') : route('questionnaire.reset') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    onclick="return confirm('Sind Sie sicher, dass Sie den Fragebogen zurücksetzen und erneut durchführen möchten? Ihre aktuellen Ergebnisse werden überschrieben.')">
                                Fragebogen erneut durchführen
                            </button>
                        </form>

                        <button onclick="window.print()"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                aria-label="Ergebnisse drucken"
                                type="button">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Ergebnisse drucken
                        </button>

                        <a href="{{ isset($is_guest) && $is_guest ? '/' : route('dashboard') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ isset($is_guest) && $is_guest ? 'Zurück zur Startseite' : 'Zurück zum Dashboard' }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
