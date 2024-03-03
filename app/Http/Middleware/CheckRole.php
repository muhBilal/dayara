<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$roles)
    {
        $roles_new = ['admin','gudang','marketing'];
        if(in_array($request->user()->role, $roles_new)){
            return $next($request);
        }
        return redirect('/');
    }
}
