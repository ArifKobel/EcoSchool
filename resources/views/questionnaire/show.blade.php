<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('BBNE-Selbsteinschätzung') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                    @if($nextQuestion)
                        <div class="mb-8">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                            <span class="text-sm font-medium text-blue-600">
                                                {{ $nextQuestion->category->name[0] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-blue-800 mb-1">
                                            {{ $nextQuestion->category->name }}
                                        </h3>
                                        <p class="text-sm text-blue-600">
                                            {{ $nextQuestion->category->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 id="question-heading" class="text-lg font-semibold text-gray-900 mb-4">
                                    Frage {{ $answeredQuestions + 1 }} von {{ $totalQuestions }}
                                </h4>

                                <p class="text-gray-700 text-lg leading-relaxed mb-6">
                                    {{ $nextQuestion->question_text }}
                                </p>

                                @if($nextQuestion->help_text)
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-blue-700">
                                                    {{ $nextQuestion->help_text }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ isset($is_guest) && $is_guest ? route('guest.questionnaire.store') : route('questionnaire.store') }}" class="space-y-4" role="form" aria-labelledby="question-heading">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ $nextQuestion->id }}">

                                    <fieldset class="space-y-3">
                                        <legend class="sr-only">Antwort auf die Frage auswählen</legend>

                                        <div class="flex items-center">
                                            <input id="answer_yes" name="answer" type="radio" value="1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   required aria-describedby="answer_yes_help">
                                            <label for="answer_yes" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                                Ja
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input id="answer_no" name="answer" type="radio" value="0"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                   aria-describedby="answer_no_help">
                                            <label for="answer_no" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                                Nein
                                            </label>
                                        </div>
                                    </fieldset>

                                    <div class="flex justify-between items-center pt-6">
                                        <a href="{{ isset($is_guest) && $is_guest ? '/' : route('dashboard') }}"
                                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                           aria-label="{{ isset($is_guest) && $is_guest ? 'Zurück zur Startseite' : 'Zurück zum Dashboard' }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            {{ isset($is_guest) && $is_guest ? 'Zurück zur Startseite' : 'Zurück zum Dashboard' }}
                                        </a>

                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                aria-describedby="submit-help">
                                            Antwort speichern und weiter
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                        <div id="submit-help" class="sr-only">Klicken Sie hier, um Ihre Antwort zu speichern und zur nächsten Frage zu gehen</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Fragebogen abgeschlossen</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Ihre Ergebnisse werden berechnet...
                            </p>
                            <div class="mt-6">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
