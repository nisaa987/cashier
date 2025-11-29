<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//membuat kelas migration anonim yang akan dijalankan laravel
return new class extends Migration
{
    /**
     * menjalankan migrasi untuk menambahkan kolom 'role' ke table 'users'
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //menambahkan kolom string 'role' dengan nilai default 'kasir'
            $table->string('role')->default('kasir');
        });
    }

    /**
     * mengembalikan perubahan (rollback) dengan menghapus kolom 'role' dari table 'users'
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //menghapus kolom 'role' dari table 'users'
            $table->dropColumn('role');
        });
    }
};
