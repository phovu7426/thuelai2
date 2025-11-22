<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageVisit;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for assets, api calls, etc.
        if (!$this->shouldTrack($request)) {
            return $next($request);
        }

        // Record the visit
        PageVisit::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'page_url' => $request->fullUrl(),
            'user_id' => $request->user()?->id
        ]);

        return $next($request);
    }

    /**
     * Determine if the request should be tracked
     */
    private function shouldTrack(Request $request): bool
    {
        // Skip tracking for assets
        if ($request->is('*.js', '*.css', '*.jpg', '*.png', '*.gif', '*.ico', 'favicon.ico')) {
            return false;
        }

        // Skip tracking for API routes
        if ($request->is('api/*')) {
            return false;
        }

        // Skip tracking for admin routes
        if ($request->is('admin/*')) {
            return false;
        }

        return true;
    }
} 