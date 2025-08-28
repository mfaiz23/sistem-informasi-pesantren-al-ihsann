<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTncIsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek jika user sudah login DAN belum menyetujui T&C
        if ($user && ! $user->accepted_tnc_at) {

            if (! $request->routeIs('dashboard') && ! $request->routeIs('logout') && ! $request->routeIs('tnc.accept')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
