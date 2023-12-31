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
        Schema::create('trns_transfer_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transfer');
            $table->string('status_tarnsfer')->nullable();
            $table->date('tanggal_bank')->nullable();
            $table->string('bank')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('flag_by_toko', ['Y', 'N'])->default('N');
            $table->string('catatan')->nullable();
            $table->enum('status', ['O', 'C'])->default('O');
            $table->enum('flag_kas_ar', ['Y', 'N'])->default('N');
            $table->enum('flag_batal', ['Y', 'N'])->default('N');
            $table->datetime('flag_batal_date');
            $table->datetime('flag_batal_by');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trns_transfer_header');
    }
};
