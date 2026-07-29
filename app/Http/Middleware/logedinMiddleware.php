<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class logedinMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    //  Check if user is already logged in
    // If so, redirect to home with a message
    public function handle(Request $request, Closure $next): Response
    {   

        if(Session()->has('user')){
            session()->flash('message', 'You are already logedIn');
            return redirect('home');
        }
        return $next($request);
    }
}
