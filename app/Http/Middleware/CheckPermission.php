<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
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
            if(!\Auth::guest() && \Auth::user()->role==0){
            return $next($request);
            }
            elseif(!\Auth::guest() && \Auth::user()->role==1 && !hash_equals($data[$dataLength],'create') && !hash_equals($data[$dataLength],'edit')){
                return $next($request);
            }
            else{
                return redirect(route('nedmin.index'))->with('error','You Dont Have Permission');
            }
    }
}
