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
        Schema::create('borrows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('request_by_id');
            $table->unsignedInteger('evaluate_by_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('equipment_id');
            $table->string('date_filed', 15)->comment('date requested');
            $table->string('reason')->comment('reason for borrowing equipment');
            $table->string('date_borrowed', 15);
            $table->string('date_returned', 15)->nullable();
            $table->integer('approval_status')->default(0);
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
        Schema::dropIfExists('borrows');
    }
};
