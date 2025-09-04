<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ihre BBNE-Ergebnisse') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Status Badge und Gesamtergebnis -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full
                                    @if($result->status === 'gold') bg-yellow-100
                                    @elseif($result->status === 'silver') bg-gray-100
                                    @else bg-amber-100 @endif mb-4">
                            <span class="text-2xl font-bold
                                       @if($result->status === 'gold') text-yellow-600
                                       @elseif($result->status === 'silver') text-gray-600
                                       @else text-amber-600 @endif">
                                {{ $result->total_points }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-2" id="result-heading">
                            {{ $result->getStatusName() }}-Status
                        </h1>

                        <p class="text-lg text-gray-600 mb-4">
                            {{ $result->percentage }}% erreicht ({{ $result->total_points }} von {{ $result->max_points }} Punkten)
                        </p>

                        <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                            <div class="h-3 rounded-full transition-all duration-500
                                        @if($result->status === 'gold') bg-yellow-500
                                        @elseif($result->status === 'silver') bg-gray-500
                                        @else bg-amber-500 @endif"
                                 style="width: {{ $result->percentage }}%"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $result->total_points }}</div>
                                <div class="text-sm text-green-600 dark:text-green-400">Ihre Punkte</div>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $result->max_points }}</div>
                                <div class="text-sm text-blue-600 dark:text-blue-400">Maximale Punkte</div>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $result->percentage }}%</div>
                                <div class="text-sm text-purple-600 dark:text-purple-400">Erreichter Score</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Handlungsfelder -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        Aufschlüsselung nach Handlungsfeldern
                    </h3>

                    <div class="space-y-4">
                        @foreach($categories as $category)
                            @php
                                $categoryScore = $result->category_scores[$category->slug] ?? ['points' => 0, 'max_points' => 0, 'percentage' => 0];
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

            <!-- Verbesserungsvorschläge -->
            @if(!empty($recommendations))
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">
                            Ihre nächsten Schritte
                        </h3>

                        <!-- Allgemeine Empfehlungen -->
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

                        <!-- Kategoriespezifische Empfehlungen -->
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

            <!-- Zusatzmaterialien -->
            @if(!empty($resources))
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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

            <!-- Aktionen -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <form method="POST" action="{{ route('questionnaire.reset') }}" class="inline">
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

                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Zurück zum Dashboard
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
