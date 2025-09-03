<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBasicRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->status == 1) {
            return redirect()->route('mypage.basic_register');
        }

        // if ($user->status == 1) {
        //     return redirect()->route('mypage');
        // }

        return $next($request);
    }
}
