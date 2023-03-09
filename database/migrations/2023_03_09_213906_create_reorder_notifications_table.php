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
        Schema::create('reorder_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_ingredient_id')->constrained('product_ingredients');
            $table->string('quantity_left');
            $table->timestamp('last_reorder_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reorder_notifications');
    }
};
