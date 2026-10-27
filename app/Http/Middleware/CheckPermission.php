<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $entity, string $action = 'read'): Response
    {
        $user = $request->user('admin');

        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated'], 401)
                : redirect()->route('admin.login');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (!$user->hasPermission($entity, $action)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Forbidden: Insufficient permissions'], 403)
                : abort(403, 'You do not have permission to ' . $action . ' ' . $entity);
        }

        return $next($request);
    }
}