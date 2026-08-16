<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * NOTE: The `status` column added here is a legacy duplicate of `payment_status`.
 *
 * History:
 *   - 2026_04_07: `payment_status` created as the canonical billing status field.
 *   - 2026_04_10: A `status` column was added in error as a second status field.
 *   - 2026_07_24: The cleanup migration dropped `status` to consolidate on `payment_status`.
 *   - 2026_08_08: This migration (erroneously) re-added `status`.
 *
 * The entire application (BillingController, views, DashboardController, AppServiceProvider,
 * ReportController) consistently reads and writes ONLY `payment_status`.
 * The `status` column is never written to and always stays on its default 'Unpaid'.
 *
 * This migration is kept for historical accuracy (it was already run on existing databases).
 * Existence guards prevent errors on fresh installations where 2026_07_24 already removed it.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Guard: do not re-add if a prior cleanup migration already removed it.
        if (Schema::hasColumn('billings', 'status')) {
            return;
        }

        Schema::table('billings', function (Blueprint $table) {
            $table->string('status')
                ->default('Unpaid')
                ->after('id');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('billings', 'status')) {
            return;
        }

        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};