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
        Schema::table('users', function (Blueprint $table) {
            $table->string('unit_kerja')->nullable();
            $table->enum('status_pns', ['PNS', 'Non-PNS'])->default('Non-PNS');
            $table->string('status_kepegawaian')->nullable();
            $table->integer('sisa_cuti')->default(12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['unit_kerja', 'status_pns', 'status_kepegawaian', 'sisa_cuti']);
        });
    }
};
