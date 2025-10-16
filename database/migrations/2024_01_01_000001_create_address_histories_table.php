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
        Schema::create('address_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address'); // Name/label for the address
            $table->decimal('latitude', 10, 8); // Latitude with 8 decimal places for precision
            $table->decimal('longitude', 11, 8); // Longitude with 8 decimal places for precision

            // Add indexes for performance
            $table->index(['user_id', 'created_at']);
            $table->index(['latitude', 'longitude']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_histories');
    }
};
