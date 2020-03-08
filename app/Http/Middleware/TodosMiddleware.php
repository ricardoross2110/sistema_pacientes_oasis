<?php

namespace App\Http\Middleware;

use Closure;

class TodosMiddleware
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
         if (Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2 || Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4) {
            return $next($request);            
        }
    }
}
