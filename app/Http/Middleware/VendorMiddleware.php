<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isVendor()) {
            abort(403, 'Unauthorized');
        }

        $vendor = auth()->user()->vendor;
        if ($vendor && $vendor->approval_status === 'suspended') {
            $allowedRoutes = ['vendor.dashboard', 'logout'];
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('vendor.dashboard')->with('error', 'Your account is suspended. Please contact admin@landscapehub.com to resolve this.');
            }
        }

        return $next($request);
    }
}
