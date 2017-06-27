<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        //dd($request->user()->role);
        if($request->user()->role != 'admin') {

            return redirect('backend')->with('error_message', 'Non hai i permessi per accedere a questa pagina');
        }

        return $next($request);
    }
}
