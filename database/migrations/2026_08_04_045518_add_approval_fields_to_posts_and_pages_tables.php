<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter posts status column to VARCHAR(30) to support draft, pending_review, published, rejected
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `posts` MODIFY COLUMN `status` VARCHAR(30) NOT NULL DEFAULT 'draft'");
        }

        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('status');
            }
            if (!Schema::hasColumn('posts', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('rejection_note')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('posts', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'status')) {
                $table->string('status', 30)->default('published')->after('is_active');
            }
            if (!Schema::hasColumn('pages', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('status');
            }
            if (!Schema::hasColumn('pages', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('rejection_note')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('pages', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
            if (!Schema::hasColumn('pages', 'last_updated_by')) {
                $table->foreignId('last_updated_by')->nullable()->after('reviewed_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
                $table->dropColumn(['rejection_note', 'reviewed_by', 'reviewed_at']);
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
            }
            if (Schema::hasColumn('pages', 'last_updated_by')) {
                $table->dropForeign(['last_updated_by']);
            }
            $table->dropColumn(['status', 'rejection_note', 'reviewed_by', 'reviewed_at', 'last_updated_by']);
        });
    }
};
