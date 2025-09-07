<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Wenn der Benutzer eingeloggt ist, erlaube den Zugriff
        if (Auth::check()) {
            return $next($request);
        }

        // Für Gäste: Prüfe ob es sich um erlaubte Routen handelt
        $allowedRoutes = [
            'guest.questionnaire.show',
            'guest.questionnaire.store',
            'guest.questionnaire.reset',
            'guest.questionnaire.progress',
            'guest.results.show'
        ];

        $currentRoute = $request->route() ? $request->route()->getName() : null;

        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }

        // Wenn es keine erlaubte Route ist, leite zur Landingpage weiter
        return redirect('/')->with('error', 'Bitte melden Sie sich an oder starten Sie den Fragebogen als Gast.');
    }
}
