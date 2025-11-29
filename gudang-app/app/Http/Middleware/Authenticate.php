<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
//mengimpor middleware bawaan laravel untuk autentikasi dan memberinya alias 'middleware'

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string 
    //fungsi ini menentukakn kemana pengguna akan diarahkan jika tidak terautentikasi
    // tipe pengembalian adalah string atau null (nullable string)
    {
        return $request->expectsJson() ?null:route('login');
        //Jika bukan JSON (misalnya akses web biasa), redirect ke route bernama 'login
    }
}
