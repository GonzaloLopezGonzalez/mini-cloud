<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckEnvAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('authenticated')) {
            return $next($request);
        }

        // Almacenar la URL intencionada
        Session::put('url.intended', $request->url());

        return redirect()->route('loginForm')->withErrors(['username' => 'Debes iniciar sesión.']);
    }
}