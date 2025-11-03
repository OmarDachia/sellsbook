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
        Schema::create('pieces_daily_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->decimal('cash_amount', 12, 2)->default(0);
            $table->decimal('transfer_amount', 12, 2)->default(0);
            $table->decimal('total_sales', 12, 2)->default(0);
            $table->decimal('shop_daily_sales', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces_daily_sales');
    }
};
