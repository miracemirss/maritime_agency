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
        Schema::create('spare_parts', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('transit_id'); // hangi geçişe ait
        
            $table->enum('direction', ['gelen', 'giden']); // geliş mi gidiş mi
            $table->string('awb_no')->nullable(); // kargo takip numarası
            $table->string('item_name'); // parça/numune adı
            $table->integer('quantity')->nullable(); // adet
            $table->string('unit')->nullable(); // kg, adet, koli, vs.
            $table->string('courier_company')->nullable(); // kargo firması (UPS, DHL, vs)
            $table->string('delivered_by')->nullable(); // kim teslim etti
            $table->string('received_by')->nullable(); // kim aldı
            $table->boolean('delivered')->default(false); // teslim durumu
            $table->timestamp('delivery_date')->nullable(); // teslim tarihi
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
        Schema::dropIfExists('spare_parts');
    }
};
