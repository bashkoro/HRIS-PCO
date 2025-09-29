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
        Schema::create('bukti_potong_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('periode'); // Period (e.g., "2024-01", "2024-02")
            $table->string('file_path')->nullable(); // Path to PDF file
            $table->text('keterangan'); // Description/notes
            $table->boolean('is_available')->default(true); // Whether file is available for download
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_potong_pajaks');
    }
};
