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
        Schema::table('bookings', function (Blueprint $table) {
            $table->float('amount');
            $table->integer('no_of_packages');
            $table->string('receiver_name');
            $table->string('receiver_number');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'amount',
                'no_of_packages',
                'receiver_name',
                'receiver_number'
            ]);
            //
        });
    }
};
