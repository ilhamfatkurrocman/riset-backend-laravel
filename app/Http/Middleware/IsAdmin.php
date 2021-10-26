<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // php artisan make:middleware IsAdmin
        // Cek status user ADMIN or USER
        // Setelah ini dibuat daftarkan di Karnel.php
        if (Auth::user() && Auth::user()->roles == 'ADMIN') {
            return $next($request);
        }

        return redirect('/');

    }
}
