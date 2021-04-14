<?php

namespace App\Http\Middleware;

use Closure;

class IPAddresses
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
        // if ($request->ip() != '13.235.12.31') {
        //     abort(403);
        // }
        return $next($request);
    }
}
