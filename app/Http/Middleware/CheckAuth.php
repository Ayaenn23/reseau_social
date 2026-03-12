<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->has('user_id') && !\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté !');
        }

        return $next($request);
    }
}
