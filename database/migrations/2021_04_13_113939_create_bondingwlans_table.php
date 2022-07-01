<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondingwlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bondingwlans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ifacebonding_id')->unsigned(); 
            $table->integer('ifacewlan_id')->unsigned();            
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
        Schema::dropIfExists('bondingwlans');
    }
}
