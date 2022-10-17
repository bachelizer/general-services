<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
            $table->integer('maintenance_interval')->length(11)->nullable()->comment('number of days')->after('equipment')->unsigned();
        });

        Schema::table('office_equipment', function (Blueprint $table) {
            //
            $table->integer('maintenance_day',)->length(11)->nullable()->comment('days remaining fro regualr maintenance')->after('date_disposed')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            //
        });
        Schema::table('office_equipment', function (Blueprint $table) {
            //
        });
    }
};
