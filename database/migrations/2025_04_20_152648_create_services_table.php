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
        Schema::create('services', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('transit_id'); // hangi geçişe ait
        
            $table->string('service_type'); // motor servisi, teknik destek, elektrik vs.
            $table->text('description')->nullable(); // ne yapıldı
            $table->string('performed_by')->nullable(); // yapan kişi/firma
            $table->timestamp('start_time')->nullable(); // hizmet başlangıç
            $table->timestamp('end_time')->nullable(); // hizmet bitiş
            $table->boolean('approved_by_captain')->default(false); // kaptan onayı
            $table->string('report_file')->nullable(); // servis raporu (pdf yolu vs.)
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
        Schema::dropIfExists('services');
    }
};
