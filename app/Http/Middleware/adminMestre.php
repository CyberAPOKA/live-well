<?php

namespace App\Http\Middleware;

use Closure;

class adminMestre{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $user = \Auth::user();
        if($user['permissao'] != 1){
            return redirect()->route('login');
        }

        return $next($request);
    }
}
