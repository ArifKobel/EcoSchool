<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BBNE-Selbsteinschätzung') }} – {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    <div class="mb-8" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="Fragebogen-Fortschritt">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">
                                Fortschritt: {{ $answeredQuestions }} von {{ $totalQuestions }} Fragen beantwortet
                            </span>
                            <span class="text-sm font-medium text-gray-700" aria-live="polite">
                                {{ $progress }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5" role="presentation">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                                 style="width: {{ $progress }}%" aria-hidden="true"></div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="category-select" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategorie auswählen
                        </label>
                        <select id="category-select" onchange="navigateToCategory(this.value)"
                                class="block w-full max-w-xs pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            @foreach($categories as $cat)
                                <option value="{{ isset($is_guest) && $is_guest ? route('guest.questionnaire.category.show', $cat) : route('questionnaire.category.show', $cat) }}"
                                        {{ $cat->id === $category->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        function navigateToCategory(url) {
                            if (url) {
                                window.location.href = url;
                            }
                        }
                    </script>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-1">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-blue-700">
                            {{ $category->description }}
                        </p>
                    </div>

                    <form method="POST" action="{{ isset($is_guest) && $is_guest ? route('guest.questionnaire.category.store', $category) : route('questionnaire.category.store', $category) }}" class="space-y-6">
                        @csrf

                        @forelse($questions as $question)
                            <div class="bg-gray-50 rounded-lg p-5">
                                <h4 class="text-base font-medium text-gray-900 mb-3">
                                    {{ $question->question_text }}
                                </h4>

                                @if($question->help_text)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4">
                                        <p class="text-sm text-blue-700">
                                            {{ $question->help_text }}
                                        </p>
                                    </div>
                                @endif

                                <fieldset class="space-y-2">
                                    <legend class="sr-only">Antwort wählen</legend>
                                    @php
                                        $existing = isset($is_guest) && $is_guest
                                            ? ($existingAnswers[$question->id]['answer'] ?? null)
                                            : optional($existingAnswers->get($question->id))->answer;
                                    @endphp
                                    <label class="inline-flex items-center mr-6">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $existing === true || $existing === 1 || $existing === '1' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Ja</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="0" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $existing === false || $existing === 0 || $existing === '0' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Nein</span>
                                    </label>
                                </fieldset>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Keine aktiven Fragen in dieser Kategorie.</p>
                        @endforelse

                        <div class="flex justify-between items-center pt-4">
                            <div>
                                <a href="{{ isset($is_guest) && $is_guest ? ( $previousCategory ? route('guest.questionnaire.category.show', $previousCategory) : '/' ) : ( $previousCategory ? route('questionnaire.category.show', $previousCategory) : route('dashboard') ) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Zurück
                                </a>
                            </div>

                            <div class="space-x-2">
                                @if($nextCategory)
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Speichern & Weiter
                                    </button>
                                @else
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Speichern & Abschließen
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


