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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('region', ['west', 'east', 'north', 'central']);
            $table->date('start_date');
            $table->unsignedInteger('duration_days');
            $table->decimal('price_per_person', 10, 2);
            $table->timestamps();

            // Add index on start_date for better performance on sorting
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
