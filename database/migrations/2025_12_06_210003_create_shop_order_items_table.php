<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_order_id')->constrained('shop_orders')->cascadeOnDelete();
            $table->foreignId('shop_product_id')->constrained('shop_products');
            $table->string('product_name');
            $table->integer('unit_price_cents');
            $table->integer('quantity');
            $table->integer('line_total_cents');
            $table->string('currency', 3)->default('USD');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_order_items');
    }
};
