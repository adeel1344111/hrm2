<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('qa_evaluations')) {
            return;
        }
        if (!Schema::hasColumn('qa_evaluations', 'qa_comments')) {
            Schema::table('qa_evaluations', function (Blueprint $table) {
                $table->text('qa_comments')->nullable()->after('call_outcome');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('qa_evaluations') && Schema::hasColumn('qa_evaluations', 'qa_comments')) {
            Schema::table('qa_evaluations', function (Blueprint $table) {
                $table->dropColumn('qa_comments');
            });
        }
    }
};
