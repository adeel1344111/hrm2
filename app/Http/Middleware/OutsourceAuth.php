<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OutsourceAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('outsource_login_access')) {
            return redirect()->route('outsource.login')
                ->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}
