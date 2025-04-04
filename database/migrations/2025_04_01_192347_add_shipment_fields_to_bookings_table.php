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
            $table->string('shipment_type')->after('status');
            $table->float('weight')->after('shipment_type');
            $table->string('dimension')->nullable()->after('weight');
        });
    }
    
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['shipment_type', 'weight', 'dimension']);
        });
    }
    
};
