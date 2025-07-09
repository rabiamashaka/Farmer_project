<?php
// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Block if not logged in OR wrong role
        if (! $request->user() || $request->user()->role !== $role) {
            // 👉 change to redirect()->route('welcome') if you’d rather send them elsewhere
            abort(403);
        }
        return $next($request);
    }
}
