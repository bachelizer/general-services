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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_status', 20);
            $table->unsignedInteger('request_by_id');
            $table->unsignedInteger('serve_by_id')->nullable()->comment('who work the maintenance request');
            $table->unsignedInteger('office_id')->comment('office whom request');
            $table->unsignedInteger('office_equipment_id')->comment('equipment within the office of requestee.');
            $table->unsignedInteger('service_id')->comment('type of service');
            $table->string('reason');
            $table->string('action_taken')->nullable();
            $table->string('remarks')->nullable()->comment('remarks/recommendations');
            $table->string('equipment_status', 20)->nullable();
            $table->string('date_filed', 15)->comment('date requested');
            $table->string('time_start', 8)->nullable();
            $table->string('time_end', 8)->nullable();

            $table->foreign('request_by_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('serve_by_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('office_equipment_id')->references('id')->on('office_equipment')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenances');
    }
};
