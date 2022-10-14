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
        Schema::table('borrows', function (Blueprint $table) {
            //
            $table->renameColumn('request_by_id', 'borrower_id');
            $table->renameColumn('evaluate_by_id', 'approver_id');
            // $table->renameColumn('reason', 'purpose');

            $table->string('rejection_remarks')->after('reason');
            $table->integer('qty')->after('equipment_id');

            $table->dropColumn('date_filed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrows', function (Blueprint $table) {
            //
        });
    }
};
