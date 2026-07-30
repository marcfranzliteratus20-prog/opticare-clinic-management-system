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
        Schema::table('inventories', function (Blueprint $table) {
            // FIX: 'stock_quantity' is a dead duplicate of 'quantity' and is
            // required with no default -- it breaks every new product save.
            if (Schema::hasColumn('inventories', 'stock_quantity')) {
                $table->dropColumn('stock_quantity');
            }

            if (!Schema::hasColumn('inventories', 'reorder_level')) {
                $table->integer('reorder_level')->default(5)->after('quantity');
            }

            if (!Schema::hasColumn('inventories', 'supplier')) {
                $table->string('supplier')->nullable()->after('price');
            }
        });

        Schema::table('billings', function (Blueprint $table) {
            // FIX: 'status' is a dead duplicate of 'payment_status' -- the
            // app only ever writes to 'payment_status', so 'status' always
            // stays stuck on its default value and gives wrong dashboard counts.
            if (Schema::hasColumn('billings', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'eye_grade')) {
                $table->string('eye_grade')->nullable()->after('address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->integer('stock_quantity')->default(0);
            $table->dropColumn(['reorder_level', 'supplier']);
        });

        Schema::table('billings', function (Blueprint $table) {
            $table->string('status')->default('Unpaid');
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('eye_grade');
        });
    }
};