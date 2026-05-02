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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Modify enum values using DB statement
            DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'dipinjam', 'dikembalikan', 'rusak', 'hilang') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Revert back to original
            DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'dipinjam', 'dikembalikan') DEFAULT 'pending'");
        });
    }
};
