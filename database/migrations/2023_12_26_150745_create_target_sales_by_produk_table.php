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
        Schema::create('target_sales_by_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('sales');
            $table->Integer('id_produk');
            $table->Integer('bulan');
            $table->Integer('tahun');
            $table->Integer('nominal');
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
        Schema::dropIfExists('target_sales_by_produk');
    }
};
