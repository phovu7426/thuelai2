<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUploadRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log tất cả request đến /upload
        if (strpos($request->path(), 'upload') !== false) {
            Log::info('Upload request intercepted by middleware', [
                'path' => $request->path(),
                'full_url' => $request->fullUrl(),
                'method' => $request->method(),
                'has_files' => !empty($request->allFiles()),
                'file_keys' => array_keys($request->allFiles()),
                'has_token' => $request->has('_token'),
                'has_cktoken' => $request->has('ckCsrfToken'),
                'content_type' => $request->header('Content-Type'),
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
            ]);
        }
        
        return $next($request);
    }
}

