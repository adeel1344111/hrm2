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
        // Make comment nullable in csr_submissions
        Schema::table('csr_submissions', function (Blueprint $table) {
            $table->text('comment')->nullable()->change();
        });

        // Make comment nullable in verification_submissions
        Schema::table('verification_submissions', function (Blueprint $table) {
            $table->text('comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert comment to NOT NULL in csr_submissions
        Schema::table('csr_submissions', function (Blueprint $table) {
            $table->text('comment')->nullable(false)->change();
        });

        // Revert comment to NOT NULL in verification_submissions
        Schema::table('verification_submissions', function (Blueprint $table) {
            $table->text('comment')->nullable(false)->change();
        });
    }
};
