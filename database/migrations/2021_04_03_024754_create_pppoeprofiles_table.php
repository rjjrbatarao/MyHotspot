<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePppoeprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pppoeprofiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->integer('rate_id')->unsigned();//
            $table->boolean('enable_rates_bw')->default(false);
            $table->integer('bandwidth_up')->unsigned();// in kbps, 1 mb = 1024000
            $table->integer('bandwidth_down')->unsigned();//                       
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pppoeprofiles');
    }
}
