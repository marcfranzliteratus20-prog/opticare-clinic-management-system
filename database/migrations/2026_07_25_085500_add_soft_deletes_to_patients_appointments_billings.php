<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('billings', function (Blueprint $table) {
            if (!Schema::hasColumn('billings', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('billings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};