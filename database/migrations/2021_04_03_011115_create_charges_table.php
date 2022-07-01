<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique(); // reference code
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();            
            $table->string('comment',255)->nullable();
            $table->integer('chargeprofile_id')->unsigned();            
            $table->integer('credit')->unsigned();
            $table->string('status')->default('unused'); //unused, active, stopped         
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
        Schema::dropIfExists('charges');
    }
}
