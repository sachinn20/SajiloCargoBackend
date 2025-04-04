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
    Schema::create('trips', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Vehicle owner ID
        $table->unsignedBigInteger('vehicle_id'); // Selected vehicle ID
        $table->string('vehicle_name'); // Store vehicle name
        $table->string('vehicle_plate'); // Store vehicle plate number
        $table->string('owner_name'); // Vehicle owner's name
        $table->string('from_location');
        $table->string('to_location');
        $table->date('date');
        $table->time('time');
        $table->enum('shipment_type', ['individual', 'group']);
        $table->float('available_capacity')->nullable(); // Only for group shipments
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
