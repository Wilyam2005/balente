<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menyesuaikan tabel riwayat_interaksis:
     * - Hapus FK destinasi_id (tidak dipakai di InteractionController)
     * - Ganti dengan kategori_id (nullable) dan bobot
     */
    public function up(): void
    {
        Schema::table('riwayat_interaksis', function (Blueprint $table) {
            // Drop FK dan kolom yang tidak dipakai
            $table->dropForeign(['user_id']);
            $table->dropForeign(['destinasi_id']);
            $table->dropColumn(['destinasi_id', 'keterangan', 'tanggal_interaksi']);

            // Tambah kolom baru sesuai InteractionController
            $table->unsignedBigInteger('kategori_id')->nullable()->after('user_id');
            $table->integer('bobot')->default(5)->after('jenis_interaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_interaksis', function (Blueprint $table) {
            $table->dropColumn(['kategori_id', 'bobot']);
            $table->foreignId('destinasi_id')->constrained('destinasis')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_interaksi')->useCurrent();
        });
    }
};
