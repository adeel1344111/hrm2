<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qa_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('qms_evaluation_id')->unique();
            $table->string('evaluation_uid', 40)->nullable();
            $table->string('agent_name')->nullable();
            $table->string('team_leader')->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('did', 40)->nullable();
            $table->string('campaign_name')->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->boolean('is_pass')->nullable();
            $table->boolean('is_critical_failure')->default(false);
            $table->decimal('sales_deduction_total', 8, 2)->default(0);
            $table->unsignedInteger('mistakes_count')->default(0);
            $table->string('call_outcome')->nullable();
            $table->dateTime('call_date')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'call_date']);
            $table->index('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qa_evaluations');
    }
};
