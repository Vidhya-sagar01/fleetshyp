<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
       
        if (!Auth::check()) {

            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }

            if ($role === 'seller_admin') {
                return redirect()->route('seller.login');
            }

            return redirect('/'); 
        }

      
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}