<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchasesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (isMainBranch() || isSupplier()) {
                return $next($request);
            } else {
                Session::flash('error', 'Only Main Branch Can Purchases');
                abort('401');
            }

        } else {
            return redirect()->route('home');
        }
    }
}
