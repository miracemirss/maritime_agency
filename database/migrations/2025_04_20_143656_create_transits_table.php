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
        Schema::create('transits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('ship_id'); // ships tablosuyla ilişki
            $table->enum('type', ['liman', 'transit']);
            $table->string('direction')->nullable(); // NB, SB, etc.
            $table->string('location')->nullable(); // örn: Çanakkale, İstanbul
            $table->date('eta')->nullable(); // Estimated Time of Arrival
            $table->date('etd')->nullable(); // Estimated Time of Departure
            $table->text('notes')->nullable();
         

              // foreign key
        $table->foreign('ship_id')->references('id')->on('ships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transits');
    }
};
