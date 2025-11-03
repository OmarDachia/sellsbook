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
        Schema::create('accounting', function (Blueprint $table) {
            $table->id();
            $table->date('as_of_date')->nullable();
            $table->decimal('capital', 14, 2)->default(0);
            $table->decimal('goods', 14, 2)->default(0);
            $table->decimal('pos', 14, 2)->default(0);
            $table->decimal('account', 14, 2)->default(0);
            $table->decimal('expense', 14, 2)->default(0);
            $table->decimal('salary', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('as_of_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting');
    }
};
