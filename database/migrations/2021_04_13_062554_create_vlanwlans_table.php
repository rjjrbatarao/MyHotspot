<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVlanwlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlanwlans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ifacevlan_id')->unsigned();
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
        Schema::dropIfExists('vlanwlans');
    }
}
