<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->float('total_distance_travelled')->default(0); // in km
        $table->float('maintenance_threshold_km')->default(1000);
        $table->enum('maintenance_status', ['maintained', 'not_maintained'])->default('maintained');
    });
}

public function down()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropColumn(['total_distance_travelled', 'maintenance_threshold_km', 'maintenance_status']);
    });
}

};
