<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            if (!Schema::hasColumn('billings', 'warranty_months')) {
                $table->unsignedInteger('warranty_months')->nullable()->after('service_type');
            }

            if (!Schema::hasColumn('billings', 'warranty_expiry')) {
                $table->date('warranty_expiry')->nullable()->after('warranty_months');
            }
        });
    }

    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['warranty_months', 'warranty_expiry']);
        });
    }
};