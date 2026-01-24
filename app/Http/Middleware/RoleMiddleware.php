<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        if (!$request->user()->hasRole($role)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. ' . ucfirst($role) . ' access required.'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'Unauthorized. ' . ucfirst($role) . ' access required.');
        }

        return $next($request);
    }
}
