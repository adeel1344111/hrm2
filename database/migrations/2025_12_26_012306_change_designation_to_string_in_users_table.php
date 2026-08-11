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
        // Change designation column to string/varchar
        DB::statement("ALTER TABLE users MODIFY COLUMN designation VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum (approximate, might fail if data doesn't match)
        // DB::statement("ALTER TABLE users MODIFY COLUMN designation ENUM('CSR', 'Verification Officer') NULL");
        DB::statement("ALTER TABLE users MODIFY COLUMN designation VARCHAR(255) NULL");
    }
};
