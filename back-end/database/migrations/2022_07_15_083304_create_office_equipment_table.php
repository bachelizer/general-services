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
        Schema::create('office_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id')->comment('office location');
            $table->unsignedInteger('user_id')->comment('property custodian');
            $table->string('code', 150);
            $table->string('serial', 150);
            $table->decimal('amount', 10, 2);
            $table->string('status', 50);
            $table->string('supplier', 100);
            $table->string('date_disposed', 50)->nullable();
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
        Schema::dropIfExists('office_equipment');
    }
};
