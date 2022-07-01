<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargeprofiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();            
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->integer('rate_id')->unsigned();//
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
        Schema::dropIfExists('chargeprofiles');
    }
}
