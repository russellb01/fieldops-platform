<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficePinMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('fieldops_office_authenticated') === true) {
            return $next($request);
        }

        return redirect()->route('office.login');
    }
}
