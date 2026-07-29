<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    // Check if user is admin
    public function handle(Request $request, Closure $next): Response
    {
        if(session()->get('user')->user_type != 'admin'){
            return redirect('home')->with('fail', 'You have no rights to perform this action!');
        }
        return $next($request);
    }
}
