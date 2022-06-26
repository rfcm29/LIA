<?php

namespace App\Http\Middleware;

use Closure;
use App\Grupo;

class Checkgrupo
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
        $grupo = Grupo::findOrFail(auth()->user()->grupo_id);
        
        $request->session()->put('grupo', $grupo);

        return $next($request);
    }
}
