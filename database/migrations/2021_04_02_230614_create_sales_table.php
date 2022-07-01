<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();            
            $table->string('name')->unique();
            $table->string('status')->default('sold');
            $table->string('service')->nullable();// hotspot or charging
            $table->macAddress('mac');// user mac address
            $table->string('user_agent')->nullable();
            $table->integer('credit')->unsigned();// credits
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
        Schema::dropIfExists('sales');
    }
}
