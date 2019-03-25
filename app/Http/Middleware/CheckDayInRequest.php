<?php

namespace App\Http\Middleware;

use Closure;

class CheckDayInRequest
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
        if ($request->day)
        {
            if ($request->day == 'today' || \DateTime::createFromFormat('Y-m-d', $request->day))
            {
                return $next($request);
            }
        }
        return response()->json([ 'success' => false, 'error' => 'Parameter day requuired' ], 422);
    }
}
