<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * - Objek request yang masuk ke aplikasi
     * @param  \Closure\(Illuminate\Http\Request): (\Symfony\Component\Http\Response) $next
     * -fungsi untuk meneruskan request ke middleware atau controller berikutnya
     * @param mixed ...$roles
     * - parameter variadic yang menerima satu atau lebih role yang diizinkan
     * @return mixed
     * - mengembalikan response, bisa berubah redirect, abort, atau response selanjutnya
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // mengecek apakah pengguna sudah login
        if (!Auth::check()) {
            //jika belum login, arahkan ke halaman login
            return redirect('/login');
        }

        // mengecek apakah role pengguna saat ini termasuk dalam daftar role yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            //jika tidak cocok, tampilkan error 403 forbidden
            abort(403, 'Akses Ditolak, Pengguna tidak memiliki izin');
        }

        // jika lolos semua pemeriksaan, lanjutkan request ke proses berikutnya
        return $next($request);
        
    }
}
