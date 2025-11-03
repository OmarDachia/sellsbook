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
        Schema::create('pieces_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 191);
            $table->string('size', 60)->nullable();
            $table->integer('no_of_ctn')->default(0);
            $table->integer('qty_by_ctn')->default(0);
            $table->decimal('cost_price_by_ctn', 12, 2)->default(0);
            $table->decimal('selling_price_per_piece', 12, 2)->default(0);
            $table->decimal('price_per_pieces_in_ctn', 12, 2)->default(0);
            $table->decimal('price_by_pcs', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('item_name');
            $table->index('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces_stocks');
    }
};
