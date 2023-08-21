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
        Schema::create('refuels', function (Blueprint $table) {
            $table->id();
            $table->integer('liters');
            $table->decimal('cost');
            $table->foreignId('user_id');
            $table->foreignId('car_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refuels');
    }
};
