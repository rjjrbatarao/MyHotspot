<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondingvlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bondingvlans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ifacebonding_id')->unsigned(); 
            $table->integer('ifacevlan_id')->unsigned();            
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
        Schema::dropIfExists('bondingvlans');
    }
}
