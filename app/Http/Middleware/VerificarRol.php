<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @param  int[]  $rol
     */
    public function handle(Request $request, Closure $next, $rol)
    {
        $rol = array_slice(func_get_args(), 2);
        foreach ($rol as $role) {
            if ($request->user()->role == $role) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'No tienes permiso para realizar esta acción.'], 403);
    }
}
