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
        Schema::create('equipment_PHP', function (Blueprint $table) {
            $table->id();
            $table->char('name');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categoriesPHP');
            $table->integer('quantity_in_stock');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_PHP');
    }
};
