<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!($request->user()->perfil_id == 1)) {
            abort(403, "¡No tienes autorización para acceder al sistema.");
        }

        return $next($request);
    }
}
