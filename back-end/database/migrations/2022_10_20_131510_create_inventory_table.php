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
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('inventory_name', 100)->comment('inventory short name');
            $table->string('name', 100)->comment('inventory long name');
            $table->string('unit', 20)->comment('liter, sack, bottle, box, sachet');
            $table->integer('base_stock')->comment('base stock quantity');
            $table->integer('available_stock')->comment('available stock quantity');
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
        Schema::dropIfExists('inventory');
    }
};
