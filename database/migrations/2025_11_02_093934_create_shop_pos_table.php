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
        Schema::create('shop_pos', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('item_name', 191);
            $table->decimal('cash_amount', 12, 2)->default(0);
            $table->decimal('transfer_amount', 12, 2)->default(0);
            $table->decimal('total_sales', 12, 2)->default(0);
            $table->decimal('pos_old_balance', 12, 2)->default(0);
            $table->decimal('pos_new_balance', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('date');
            $table->index('item_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_pos');
    }
};
