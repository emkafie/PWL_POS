<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        $user_role = $request->user()->getRole(); // Mendapatkan role pengguna saat ini
        if (in_array($user_role, $roles)) {
            // Jika pengguna memiliki peran yang sesuai, lanjutkan ke request berikutnya
            return $next($request);
        }
        // Jika pengguna tidak memiliki peran yang sesuai, redirect ke halaman login atau tampilkan pesan error
        abort(403, 'Unauthorized action. Kamu tidak punya akses ke halaman ini');
    }
}
