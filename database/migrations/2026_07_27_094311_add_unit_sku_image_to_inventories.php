<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'unit')) {
                $table->string('unit')->nullable()->default('pcs')->after('quantity');
            }

            if (!Schema::hasColumn('inventories', 'sku')) {
                $table->string('sku')->nullable()->after('product_name');
            }

            if (!Schema::hasColumn('inventories', 'image')) {
                $table->string('image')->nullable()->after('supplier');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['unit', 'sku', 'image']);
        });
    }
};