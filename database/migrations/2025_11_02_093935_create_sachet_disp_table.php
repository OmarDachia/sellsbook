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
        Schema::create('sachet_disp', function (Blueprint $table) {
            $table->id();
           $table->date('date')->nullable();
            $table->string('batch', 191);
            $table->integer('total_no')->default(0);
            $table->integer('sold_out')->default(0);
            $table->integer('available')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index('date');
            $table->index('batch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sachet_disp');
    }
};
