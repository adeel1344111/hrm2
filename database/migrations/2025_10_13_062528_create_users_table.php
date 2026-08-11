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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['admin', 'floor_manager', 'team_lead', 'agent'])->default('agent');
            $table->string('employee_id')->unique();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('cnic')->nullable();
            $table->date('appointment_date')->nullable();
            $table->date('left_date')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('phone')->nullable();
            $table->string('department')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            // Hierarchy relationships
            $table->foreignId('floor_manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('team_lead_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
