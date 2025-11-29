<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Cek dulu apakah kolom dan foreign key-nya ada
            if (Schema::hasColumn('employees', 'departemen_id')) {
                $table->dropForeign(['departemen_id']);
                $table->dropColumn('departemen_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('departemen_id')->nullable();

            // Kembalikan foreign key kalau mau
            $table->foreign('departemen_id')
                  ->references('id')
                  ->on('departemen')
                  ->onDelete('cascade');
        });
    }
};
