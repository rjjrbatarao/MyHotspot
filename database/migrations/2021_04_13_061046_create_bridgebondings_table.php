<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBridgebondingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bridgebondings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ifacebridge_id')->unsigned(); 
            $table->integer('ifacebonding_id')->unsigned();                       
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bridgebondings');
    }
}
