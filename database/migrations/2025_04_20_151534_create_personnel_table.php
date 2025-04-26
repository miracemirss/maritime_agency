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
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transit_id'); // geçiş ile ilişki
            $table->enum('movement', ['gelen', 'giden']); // geliş mi gidiş mi
            $table->string('full_name'); // tam ad
            $table->string('nationality'); // uyruk
            $table->string('rank')->nullable(); // görev / pozisyon
            $table->timestamp('movement_date')->nullable(); // giriş/çıkış tarihi
            $table->boolean('visa_required')->default(false); // vize gerekli mi
            $table->boolean('hotel_needed')->default(false); // otel konaklaması
            $table->boolean('meal_needed')->default(false); // yemek durumu
            $table->string('pickup_area')->nullable(); // karşılayan bölge (örneğin: "Atatürk Havalimanı")
            $table->string('flight_no')->nullable(); // uçuş numarası (gidiş için)
        
            $table->timestamps();
        
            $table->foreign('transit_id')->references('id')->on('transits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};
