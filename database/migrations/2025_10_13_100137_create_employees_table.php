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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('employee_id')->unique();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('cnic')->nullable();
            $table->date('appointment_date')->nullable();
            $table->date('left_date')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('phone')->nullable();
            $table->enum('user_type', ['admin', 'floor_manager', 'team_lead', 'agent']);
            $table->string('department')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->unsignedBigInteger('floor_manager_id')->nullable();
            $table->unsignedBigInteger('team_lead_id')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('floor_manager_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('team_lead_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
