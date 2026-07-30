<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->integer('change'); // positive = stock in, negative = stock out
            $table->integer('previous_quantity');
            $table->integer('new_quantity');
            $table->string('reason'); // e.g. Restock, Sold, Damaged/Expired, Correction, Initial Stock
            $table->string('user_name')->nullable(); // who made the change (session user_name at the time)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};