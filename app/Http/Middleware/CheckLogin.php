<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(\Auth::guest()){
        return $next($request);
        }
        elseif((\Auth::user()->role==2)){
            return $next($request);
        }
        else{
            return redirect(route('nedmin.index'));
        }
    }
}