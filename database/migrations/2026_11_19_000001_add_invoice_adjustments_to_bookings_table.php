<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // What the system calculated before any admin adjustment.
            $table->unsignedInteger('calculated_amount')->nullable()->after('total_amount');

            // standard | discount | custom_total
            $table->string('pricing_mode')->default('standard')->after('calculated_amount');
            $table->string('discount_type')->nullable()->after('pricing_mode'); // percent | fixed
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
            $table->unsignedInteger('manual_total')->nullable()->after('discount_value');
            $table->string('adjustment_label')->nullable()->after('manual_total'); // shown to guest
            $table->text('adjustment_reason')->nullable()->after('adjustment_label'); // internal only
            $table->foreignId('adjusted_by')->nullable()->after('adjustment_reason')->constrained('users')->nullOnDelete();

            $table->string('invoice_number')->nullable()->unique()->after('reference');
            $table->timestamp('invoice_issued_at')->nullable()->after('invoice_number');
            $table->date('invoice_due_at')->nullable()->after('invoice_issued_at');
            $table->text('invoice_note')->nullable()->after('invoice_due_at'); // shown to guest
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('adjusted_by');
            $table->dropUnique(['invoice_number']);
            $table->dropColumn([
                'calculated_amount', 'pricing_mode', 'discount_type', 'discount_value',
                'manual_total', 'adjustment_label', 'adjustment_reason',
                'invoice_number', 'invoice_issued_at', 'invoice_due_at', 'invoice_note',
            ]);
        });
    }
};
