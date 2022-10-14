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
        Schema::disableForeignKeyConstraints();
        Schema::table('maintenances', function (Blueprint $table) {
            //
            $table->dropForeign('maintenances_serve_by_id_foreign');
            $table->string('request_status', 20)->default('Pending')->comment('Pending/Declined/Approved')->change();
            $table->unsignedInteger('serve_by_id')->nullable()->comment('who work the maintenance request')->change();

            $table->foreign('serve_by_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintenances', function (Blueprint $table) {
            //
        });
    }
};
