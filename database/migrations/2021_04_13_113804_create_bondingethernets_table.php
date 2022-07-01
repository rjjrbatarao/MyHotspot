<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBondingethernetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bondingethernets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ifacebonding_id')->unsigned(); 
            $table->integer('ifaceethernet_id')->unsigned();            
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
        Schema::dropIfExists('bondingethernets');
    }
}
