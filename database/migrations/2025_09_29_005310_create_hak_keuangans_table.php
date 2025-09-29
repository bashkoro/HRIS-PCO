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
        Schema::create('hak_keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slip_gaji'); // Slip gaji number/identifier
            $table->string('periode'); // Period (e.g., "2024-01", "2024-02")
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->decimal('hak_keuangan', 15, 2); // Financial rights amount
            $table->decimal('pph_21', 15, 2)->default(0); // PPH 21 tax
            $table->decimal('iuran_bpjs', 15, 2)->default(0); // BPJS contribution
            $table->decimal('penghasilan_bersih', 15, 2); // Net income
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hak_keuangans');
    }
};
