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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('season_name');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->unsignedInteger('rate_per_person')->nullable();
            $table->unsignedInteger('rate_per_couple')->nullable();
            $table->unsignedInteger('extra_person_rate')->nullable();
            $table->unsignedTinyInteger('min_nights')->nullable();
            $table->unsignedTinyInteger('max_nights')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
