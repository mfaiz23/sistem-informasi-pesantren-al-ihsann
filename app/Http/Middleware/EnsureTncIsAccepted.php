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
        if ($user && !$user->accepted_tnc_at) {
            
            // Daftar rute yang diizinkan untuk diakses sebelum menyetujui T&C
            $allowedRoutes = [
                'dashboard',
                'logout',
                'tnc.accept',
                'verification.notice', 
                'verification.verify', 
                'verification.send',   
            ];

            // Jika rute yang sedang diakses TIDAK ADA dalam daftar yang diizinkan
            if (!in_array($request->route()->getName(), $allowedRoutes)) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
