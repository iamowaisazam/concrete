<?php

namespace App\Http\Middleware;

use App\Models\Membership;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $auth = Auth::user();
         
        if($auth->user_type == 0){

            $membership = Membership::where('user_id', $auth->id)
                            ->where('membership_status', 'Active')
                            ->whereDate('membership_start_date', '<=', now())
                            ->whereDate('membership_expiry_date', '>=', now())
                            ->first();

            if ($membership) {
                
            }else{
                return redirect('/checkout')->with('error', 'No active membership found. Please subscribe or renew your plan.');
            }
            
        }

        return $next($request);
    }
}
