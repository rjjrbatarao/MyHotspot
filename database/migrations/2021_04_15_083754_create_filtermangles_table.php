<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltermanglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filtermangles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iptablefilter_id')->unsigned();
            $table->integer('iptablemangle_id')->unsigned();    
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
        Schema::dropIfExists('filtermangles');
    }
}
