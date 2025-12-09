<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    /**
     * 
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     */
    public function handle(Request $request, Closure $next): Response
    {

        $auth = Auth::user();
        if(Auth::check()){
            if($auth->user_type == 0){

                if($request->ajax()){
                    
                }else{

                    return redirect('/login')->with('error', 'Restricted');
                }
                
            }
        }
        
     

        return $next($request);

    }


}
