<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('PenjualanID');                  // Primary key dengan nama PenjualanID
            $table->date('tanggalPenjualan');           // Kolom tanggal penjualan
            $table->decimal('totalHarga', 10, 2);       // Kolom total harga penjualan
            $table->unsignedBigInteger('pelangganID');  // Foreign key ke tabel pelanggan
            $table->unsignedBigInteger('user_id');      // Foreign key ke tabel users
            $table->timestamps();                       // Kolom created_at dan updated_at

            // Relasi foreign key pelangganID ke tabel pelanggan, hapus data terkait saat pelanggan dihapus
            $table->foreign('pelangganID')
                ->references('PelangganID')
                ->on('pelanggan')
                ->onDelete('cascade');

            // Relasi foreign key user_id ke tabel users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
