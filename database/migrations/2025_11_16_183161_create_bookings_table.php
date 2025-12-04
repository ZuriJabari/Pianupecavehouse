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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->unsignedTinyInteger('guests_adults')->default(1);
            $table->unsignedTinyInteger('guests_children')->default(0);
            $table->unsignedTinyInteger('rooms_requested')->default(1);
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('nights');
            $table->string('status')->default('pending');
            $table->unsignedInteger('total_amount');
            $table->string('currency', 3)->default('USD');
            $table->json('rate_snapshot')->nullable();
            $table->json('add_ons')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
