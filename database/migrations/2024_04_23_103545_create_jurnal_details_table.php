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
        Schema::create('jurnal_details', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('id_header');
            $table->string('id_perkiraan');
            $table->text('debet');
            $table->text('kredit');
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
        Schema::dropIfExists('jurnal_details');
    }
};
