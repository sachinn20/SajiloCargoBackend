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
    Schema::table('vehicles', function ($table) {
        $table->float('last_maintenance_at_distance')->default(0);
    });
}

public function down()
{
    Schema::table('vehicles', function ($table) {
        $table->dropColumn('last_maintenance_at_distance');
    });
}

};
