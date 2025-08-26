<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Cek apakah pengguna sudah login
            if (Auth::guard($guard)->check()) {

                // Ambil data user yang sedang login
                $user = Auth::user();

                // PERIKSA ROLE: Jika rolenya 'admin', arahkan ke dashboard admin
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // JIKA BUKAN ADMIN: Arahkan ke dashboard user biasa (default)
                return redirect('/dashboard');
            }
        }

        // Jika pengguna belum login, lanjutkan request seperti biasa
        return $next($request);
    }
}
