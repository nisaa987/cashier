<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pelanggan', 'jenis_pelanggan')) {
            Schema::table('pelanggan', function (Blueprint $table) {
                $table->string('jenis_pelanggan')->default('biasa');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pelanggan', 'jenis_pelanggan')) {
            Schema::table('pelanggan', function (Blueprint $table) {
                $table->dropColumn('jenis_pelanggan');
            });
        }
    }
};
