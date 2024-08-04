<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $level
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $level = null)
    {
        // Logika untuk memeriksa level
        if ($level && auth()->user() && auth()->user()->level !== $level) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
