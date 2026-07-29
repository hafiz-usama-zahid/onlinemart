<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    //  Check if user is logged in
    // If not, redirect to login page with a message
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session()->has('user')){
            return redirect('login')->with('fail', 'You have to login your account first!');
        }
        return $next($request);
    }
}
