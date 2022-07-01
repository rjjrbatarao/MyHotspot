<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePppoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pppoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user')->unique(); //
            $table->string('comment',255)->nullable();
            $table->string('secret')->nullable();
            $table->integer('pppoeprofile_id')->unsigned();
            $table->integer('pppoeaccount_id')->unsigned();
            $table->ipAddress('ip')->nullable();// optional
            $table->integer('credit')->unsigned();
            $table->string('status')->default('unused');
            $table->integer('limit-uptime')->unsigned();
            $table->integer('used-uptime')->unsigned();            
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
        Schema::dropIfExists('pppoes');
    }
}
