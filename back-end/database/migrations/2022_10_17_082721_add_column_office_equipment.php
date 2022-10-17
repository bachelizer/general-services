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
        Schema::table('office_equipment', function (Blueprint $table) {
            //
            $table->integer('days_maintenance')->length(11)->nullable()->comment('base days for regular maintenance, from equipment maintenance_interval')->after('date_disposed')->unsigned();
            $table->integer('maintained_by')->length(11)->nullable()->comment('base days for regular maintenance, from equipment maintenance_interval')->after('date_disposed')->unsigned();
            $table->string('action_taken')->nullable()->comment('action taken on regular maintenance');

            $table->foreign('maintained_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('office_equipment', function (Blueprint $table) {
            //
        });
    }
};
