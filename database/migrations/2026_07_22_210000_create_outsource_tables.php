<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('outsource_companies')) {
            Schema::create('outsource_companies', function (Blueprint $table) {
                $table->increments('id');
                $table->string('company_name')->unique();
                $table->string('company_pass');
                $table->string('company_email');
                $table->string('admin_pass');
                $table->string('admin_name');
            });
        }

        if (!Schema::hasTable('outsource_frontor_submissions')) {
            Schema::create('outsource_frontor_submissions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('dialer_id', 10);
                $table->string('name');
                $table->string('campaign');
                $table->string('phone', 15);
                $table->string('state', 100)->nullable();
                $table->string('zip', 10)->nullable();
                $table->integer('age')->nullable();
                $table->text('comment')->nullable();
                $table->string('company');
                $table->dateTime('created_at');

                $table->index(['company', 'created_at'], 'idx_ofs_company_created');
                $table->index(['dialer_id', 'phone'], 'idx_ofs_dialer_phone');
                $table->index('phone', 'idx_ofs_phone');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('outsource_frontor_submissions');
        Schema::dropIfExists('outsource_companies');
    }
};
