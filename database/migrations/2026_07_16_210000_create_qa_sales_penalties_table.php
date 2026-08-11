<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qa_sales_penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('qms_evaluation_id');
            $table->unsignedInteger('qms_answer_id')->unique();
            $table->string('phone_number', 32)->nullable();
            $table->string('violation_category', 64);
            $table->enum('penalty_decision', ['apply', 'approved_by_tl']);
            $table->decimal('sales_deduction', 8, 2)->nullable();
            $table->string('penalty_outcome', 40)->nullable();
            $table->dateTime('occurred_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'occurred_at']);
            $table->index('qms_evaluation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qa_sales_penalties');
    }
};
