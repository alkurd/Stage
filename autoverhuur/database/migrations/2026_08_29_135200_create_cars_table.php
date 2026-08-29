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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("merk");
            $table->string("model");
            $table->integer("bouwjaar");
            $table->decimal("price_per_day");
            $table->text("omschrijving")->nullable();
            $table->boolean("beschikbaar")->default(true);
            $table->string("primary_image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
