<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'vehicle_owner', 'admin') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'vehicle_owner') NOT NULL");
    }
};
