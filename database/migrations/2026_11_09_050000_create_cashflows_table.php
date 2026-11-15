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
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 60)->unique();
            $table->enum('tipe', ['masuk', 'keluar'])->default('masuk'); // masuk = Pemasukan, keluar = Pengeluaran
            $table->string('kode_kategori', 30)->nullable();            // misal KM-ADM, KK-GJI
            $table->string('kategori', 120);                            // misal Pendaftaran Siswa Baru, Gaji Pegawai
            $table->decimal('nominal', 15, 2)->default(0);              // Jumlah uang kas
            $table->date('tanggal');                                    // Tanggal transaksi
            $table->text('deskripsi')->nullable();                      // Keterangan / rincian
            $table->string('nama_pihak', 150)->nullable();              // Pihak terkait (nama siswa, pegawai, vendor)
            $table->string('metode_pembayaran', 60)->default('Transfer Bank'); // Transfer Bank, Tunai, QRIS, dll
            $table->string('lampiran')->nullable();                     // Bukti transaksi / kwitansi (opsional)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes for fast filtering & sorting
            $table->index('tipe');
            $table->index('tanggal');
            $table->index('kategori');
            $table->index('kode_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashflows');
    }
};

