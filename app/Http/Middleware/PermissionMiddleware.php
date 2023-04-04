<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param User $user
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $request->user()->role_id == 1 ? $next($request) : response([
            'status' => 'error',
            'message' => 'Unauthorized'
        ], 404);
    }
}
