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
        if (Auth::check()) {
            return $next($request);
        }

        $allowedRoutes = [
            'guest.questionnaire.show',
            'guest.questionnaire.store',
            'guest.questionnaire.category.show',
            'guest.questionnaire.category.store',
            'guest.questionnaire.reset',
            'guest.questionnaire.progress',
            'guest.results.show'
        ];

        $currentRoute = $request->route() ? $request->route()->getName() : null;

        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Bitte melden Sie sich an oder starten Sie den Fragebogen als Gast.');
    }
}
