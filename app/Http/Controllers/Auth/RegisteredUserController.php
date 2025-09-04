<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isAnonymous = $request->has('anonymous_mode') && $request->anonymous_mode == 'on';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_type' => ['nullable', 'string', 'in:grundschule,hauptschule,realschule,gymnasium,gesamtschule,berufsschule,fachschule,andere'],
            'school_location' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:schulleitung,lehrkraft,sonstige'],
            'data_consent' => ['required', 'accepted'],
            'anonymous_mode' => ['nullable']
        ]);

        // Wenn anonymer Modus aktiviert ist, lösche Schul-Informationen
        $schoolData = [];
        if (!$isAnonymous) {
            $schoolData = [
                'school_name' => $request->school_name,
                'school_type' => $request->school_type,
                'school_location' => $request->school_location,
                'role' => $request->role,
            ];
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'data_consent' => true,
            'consent_given_at' => now(),
            'anonymous_mode' => $isAnonymous,
            'preferences' => ['theme' => 'light', 'language' => 'de'],
            ...$schoolData
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
