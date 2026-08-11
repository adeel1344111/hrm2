<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qa_sales_penalties', function (Blueprint $table) {
            if (!Schema::hasColumn('qa_sales_penalties', 'source')) {
                $table->string('source', 20)->default('evaluation')->after('user_id');
            }
            if (!Schema::hasColumn('qa_sales_penalties', 'qms_manual_penalty_id')) {
                $table->unsignedInteger('qms_manual_penalty_id')->nullable()->after('qms_answer_id');
            }
            if (!Schema::hasColumn('qa_sales_penalties', 'reason')) {
                $table->text('reason')->nullable()->after('penalty_outcome');
            }
            if (!Schema::hasColumn('qa_sales_penalties', 'created_by_name')) {
                $table->string('created_by_name')->nullable()->after('reason');
            }
        });

        // Allow evaluation-linked OR manual rows (qms_answer_id unique only when set)
        Schema::table('qa_sales_penalties', function (Blueprint $table) {
            $table->unsignedInteger('qms_answer_id')->nullable()->change();
            $table->unsignedInteger('qms_evaluation_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('qa_sales_penalties', function (Blueprint $table) {
            foreach (['source', 'qms_manual_penalty_id', 'reason', 'created_by_name'] as $col) {
                if (Schema::hasColumn('qa_sales_penalties', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
