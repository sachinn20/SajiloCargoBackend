<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name'); // ✅ Full name of the user

            // Business Info
            $table->string('company_name')->nullable();
            $table->string('transport_license_id')->nullable();
            $table->string('address')->nullable();

            // Bank Info
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();

            // Documents
            $table->string('transport_license_document')->nullable();
            $table->string('vehicle_registration_document')->nullable();

            $table->boolean('kyc_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
