<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAnyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!auth()->user() || !auth()->user()->canAny($permissions)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        return $next($request);
    }
}
