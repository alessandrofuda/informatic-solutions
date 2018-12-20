<?php

namespace App\Http\Middleware;

use Closure;

class SubscriberMiddleware
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
        if(!$request->user()->is_subscriber()){
            return redirect()->back()->with('error_message','Non hai i permessi per accedere a questa pagina');
        }

        return $next($request);
    }
}
