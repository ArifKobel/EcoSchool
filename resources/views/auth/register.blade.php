<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Schul-Informationen (optional) -->
        <div class="mt-6" id="school-info-section">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Schul-Informationen (optional)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- School Name -->
                <div>
                    <x-input-label for="school_name" :value="__('Schulname')" />
                    <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" autocomplete="organization" />
                    <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                </div>

                <!-- School Type -->
                <div>
                    <x-input-label for="school_type" :value="__('Schulart')" />
                    <select id="school_type" name="school_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Bitte wählen...</option>
                        <option value="grundschule" {{ old('school_type') == 'grundschule' ? 'selected' : '' }}>Grundschule</option>
                        <option value="hauptschule" {{ old('school_type') == 'hauptschule' ? 'selected' : '' }}>Hauptschule</option>
                        <option value="realschule" {{ old('school_type') == 'realschule' ? 'selected' : '' }}>Realschule</option>
                        <option value="gymnasium" {{ old('school_type') == 'gymnasium' ? 'selected' : '' }}>Gymnasium</option>
                        <option value="gesamtschule" {{ old('school_type') == 'gesamtschule' ? 'selected' : '' }}>Gesamtschule</option>
                        <option value="berufsschule" {{ old('school_type') == 'berufsschule' ? 'selected' : '' }}>Berufsschule</option>
                        <option value="fachschule" {{ old('school_type') == 'fachschule' ? 'selected' : '' }}>Fachschule</option>
                        <option value="andere" {{ old('school_type') == 'andere' ? 'selected' : '' }}>Andere</option>
                    </select>
                    <x-input-error :messages="$errors->get('school_type')" class="mt-2" />
                </div>

                <!-- School Location -->
                <div>
                    <x-input-label for="school_location" :value="__('Standort')" />
                    <x-text-input id="school_location" class="block mt-1 w-full" type="text" name="school_location" :value="old('school_location')" autocomplete="address-level2" />
                    <x-input-error :messages="$errors->get('school_location')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Ihre Rolle')" />
                    <select id="role" name="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Bitte wählen...</option>
                        <option value="schulleitung" {{ old('role') == 'schulleitung' ? 'selected' : '' }}>Schulleitung</option>
                        <option value="lehrkraft" {{ old('role') == 'lehrkraft' ? 'selected' : '' }}>Lehrkraft</option>
                        <option value="sonstige" {{ old('role') == 'sonstige' ? 'selected' : '' }}>Sonstige</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
            </div>
        </div>

        <script>
            document.getElementById('anonymous_mode').addEventListener('change', function() {
                const schoolInfoSection = document.getElementById('school-info-section');
                if (this.checked) {
                    schoolInfoSection.style.opacity = '0.5';
                    schoolInfoSection.style.pointerEvents = 'none';
                } else {
                    schoolInfoSection.style.opacity = '1';
                    schoolInfoSection.style.pointerEvents = 'auto';
                }
            });

            // Initialer Zustand prüfen
            if (document.getElementById('anonymous_mode').checked) {
                document.getElementById('school-info-section').style.opacity = '0.5';
                document.getElementById('school-info-section').style.pointerEvents = 'none';
            }
        </script>

        <!-- DSGVO Einwilligung -->
        <div class="mt-6">
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="data_consent" name="data_consent" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="data_consent" class="font-medium text-gray-700 dark:text-gray-300">
                            Datenschutz-Einwilligung *
                        </label>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">
                            Ich stimme der Verarbeitung meiner Daten gemäß der
                            <a href="{{ route('privacy') }}" target="_blank" class="text-indigo-600 hover:text-indigo-500 underline">Datenschutzerklärung</a>
                            zu. Diese Einwilligung kann ich jederzeit widerrufen.
                        </p>
                        <x-input-error :messages="$errors->get('data_consent')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Anonyme Nutzung -->
        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="anonymous_mode" name="anonymous_mode" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('anonymous_mode') ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                    <label for="anonymous_mode" class="font-medium text-gray-700 dark:text-gray-300">
                        Anonyme Nutzung
                    </label>
                    <p class="text-gray-500 dark:text-gray-400">
                        Ich möchte die Anwendung anonym nutzen. Schul-Informationen werden nicht gespeichert.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
