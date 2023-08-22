<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!\Auth::guest() && (\Auth::user()->role==0 || \Auth::user()->role==1)){
        return $next($request);
        }
        else{
            return redirect(route('nedmin.Login'))->with('error','You Dont Have Permission');
        }
    }
}
