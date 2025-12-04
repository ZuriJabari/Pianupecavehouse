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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('max_rooms')->default(3);
            $table->string('base_currency', 3)->default('USD');
            $table->unsignedTinyInteger('min_nights')->default(1);
            $table->unsignedTinyInteger('max_nights')->nullable();
            $table->unsignedInteger('default_rate_per_person')->default(220);
            $table->unsignedInteger('default_rate_per_couple')->default(330);
            $table->unsignedTinyInteger('capacity_per_room')->default(2);
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
