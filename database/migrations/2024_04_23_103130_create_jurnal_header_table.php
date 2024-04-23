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
        Schema::create('jurnal_header', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('trx_date');
            $table->text('trx_from');
            $table->text('keterangan');
            $table->text('catatan');
            $table->text('kategori');
            $table->enum('flag_batal', ['Y', 'N'])->default('N');
            $table->string('keterangan_batal');
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->timestamps();
            $table->datetime('created_by')->nullable();
            $table->datetime('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_header');
    }
};
