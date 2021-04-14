<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Auth;
use Cache;
use DB;
use Carbon\Carbon;

class UserActivity
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
        $last = DB::table('sessions')->latest('id')->first();;
        if (Auth::check()) {
            $expire = Carbon::now()->addMinutes($last->session_expire);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expire);
            User::where('id', Auth::user()->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }
        return $next($request);
    }
}
