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
        Schema::create('needs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transit_id'); // geçişle ilişki
        
            $table->string('type'); 
            // örn: ikmal, para, numune, konaklama, lojistik, paket, vs.
        
            $table->string('item')->nullable(); 
            // örn: "Fuel", "Food", "Cash", "Sample", "Paket", vs.
        
            $table->decimal('quantity', 10, 2)->nullable(); 
            // örn: 200.50
        
            $table->string('unit')->nullable(); 
            // örn: kg, litre, adet, TL, USD, kişi, vs.
        
            $table->string('currency')->nullable(); 
            // sadece type=para için örn: TL, USD
        
            $table->string('tracking_no')->nullable(); 
            // kargo, numune, paketler için
        
            $table->string('location')->nullable(); 
            // teslimat veya ihtiyaç yeri (otel, liman, tesis)
        
            $table->timestamp('requested_at')->nullable(); 
            $table->timestamp('delivered_at')->nullable();
        
            $table->boolean('delivered')->default(false);
            $table->text('notes')->nullable(); 
        
            $table->timestamps();
        
            $table->foreign('transit_id')->references('id')->on('transits')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs');
    }
};
