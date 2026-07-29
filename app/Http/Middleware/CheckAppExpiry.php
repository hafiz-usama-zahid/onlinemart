<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckAppExpiry
{
    public function handle($request, Closure $next)
    {
        $expiryDate = config('app.expiry_date');

        // If expired, block access
        if (Carbon::now()->greaterThan(Carbon::parse($expiryDate))) {
            return response()->view('expired'); // show expired page
        }

        return $next($request);
    }
}
