<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user() || !$request->user()->roles) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this area.');
        }

        foreach ($request->user()->roles as $userRole) {
            if (in_array($userRole->slug, $roles)) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard')
            ->with('error', 'You do not have permission to access this area.');
    }
}
