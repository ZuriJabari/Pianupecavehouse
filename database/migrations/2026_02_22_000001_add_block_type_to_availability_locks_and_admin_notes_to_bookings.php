<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('availability_locks', function (Blueprint $table) {
            $table->string('block_type')->default('blocked')->after('reason');
            // block_type: blocked | booked | maintenance | reserved
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('availability_locks', function (Blueprint $table) {
            $table->dropColumn('block_type');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }
};
