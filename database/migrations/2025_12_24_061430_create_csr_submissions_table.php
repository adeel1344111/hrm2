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
        Schema::create('csr_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('employee_name');
            $table->string('team_lead_name');
            $table->string('campaign');
            $table->string('phone');
            $table->string('state');
            $table->string('zip_code');
            $table->text('comment');
            $table->unsignedBigInteger('submitted_by');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index(['submitted_by', 'created_at']);
            $table->index('campaign');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csr_submissions');
    }
};
