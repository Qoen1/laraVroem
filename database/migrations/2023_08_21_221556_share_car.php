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
        schema::table('car_user', function (Blueprint $table) {
            $table->dateTime('activated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('car_user', function (Blueprint $table) {
            $table->removeColumn('activated_at');
        });
    }
};
