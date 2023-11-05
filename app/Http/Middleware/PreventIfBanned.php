<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_banned) {
            $message =  'تم وقف دخولك للوحه التحكم برجاء التحدث مع الدعم الفنى' ;
            Auth::logout();
            return redirect()->route('login')->with('error', $message);
        }
        return $next($request);
    }
}
