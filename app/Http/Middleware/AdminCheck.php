<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        if ($request->path()=='app/admin_login') {
            return $next($request);
        }
        //first check if you are logged in
        //\Log::info('inside middleware');
        if(!Auth::check() ) {
            return response()->json([
                'msg'=> 'Access Denied...'
            ], 403);
        }
        //if logged in... check if you are an  Admin User
        $user = Auth::user();
        //dd($user);
        if($user->role->isAdmin == 0) {
            return response()->json([
                'msg'=> 'Access Denied...'
            ], 403);
        }
        return $next($request);
    }
}
