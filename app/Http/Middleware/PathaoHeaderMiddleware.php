<?php

namespace App\Http\Middleware;

use Closure;
use Doctrine\DBAL\Driver\PDO\Exception;
use Illuminate\Http\Request;

class PathaoHeaderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->header('x-pathao-signature') || !$request->header('Content-Type')) {
            return response()->json("Please set header");
        }
        if($request->header('x-pathao-signature') != config('app.pathao_signature')) {
            return response()->json("Signature mismatch");
        }
        return $next($request);
    }
}
