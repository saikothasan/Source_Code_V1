<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (@Auth::user()->branch_id){
                if(@Auth::user()->is_main_branch) {
                    Session::flash('error', 'Main Branch Can Not Sale!');
                    return redirect()->route('home');
                }
                return $next($request);
            } else {
                Session::flash('error', 'Branch permission not assign!');

                abort('401');
            }

        } else {

            return redirect('/');
        }
    }
}
