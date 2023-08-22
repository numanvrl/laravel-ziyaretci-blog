<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data=explode("/",$request->getPathInfo());
        $dataLength=count($data)-1;
            if(!\Auth::guest()){
            return $next($request);
            }
            elseif(!hash_equals($data[$dataLength],'create')){
                return $next($request);
            }
            else{
                return redirect(route('default.index'))->with('error','Please Login or Register');
            }
    }
}
