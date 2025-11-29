<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * the URIs that should be excluded from CSRF verification.
     *
     * Daftar endpoint (URI) yang dikecualikan dari proses verifikasi CSRF.
     * Ini berguna untuk API atau webhook yang tidak menggunakan form/token CSRF.
     * 
     * @var array<int, string>
     */
    protected $except = [
        //
        // contoh:'api/receive-data', 'webhook/payment-callback'
        // tambahkan URI disini jika tidak ingin dikenal pemeriksaan CSRF
    ];
}
