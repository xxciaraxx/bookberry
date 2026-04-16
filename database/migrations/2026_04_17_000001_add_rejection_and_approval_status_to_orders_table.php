<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'approval_status')) {
                $table->string('approval_status', 20)->default('pending')->after('status');
            }

            if (! Schema::hasColumn('orders', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_by');
            }

            if (! Schema::hasColumn('orders', 'rejected_by')) {
                $table->foreignId('rejected_by')
                    ->nullable()
                    ->after('rejected_at')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'rejected_by')) {
                $table->dropConstrainedForeignId('rejected_by');
            }

            if (Schema::hasColumn('orders', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }

            if (Schema::hasColumn('orders', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });
    }
};

