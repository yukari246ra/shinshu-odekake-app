<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ▼ ログインしていない場合はログインへ
        if (!auth()->check()) {
            return redirect('/login');
        }

        // ▼ role が admin でなければ 403 Forbidden
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
