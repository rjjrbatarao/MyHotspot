<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientprofiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();            
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->string('type'); // time or data options
            $table->string('mode')->default('continuous'); // pausable / continuous
            $table->integer('rate_id')->unsigned();//
            $table->string('case')->default('disabled'); // upper, lower, disabled option
            $table->integer('length')->unsigned();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('credit_affix')->nullable();
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
        Schema::dropIfExists('clientprofiles');
    }
}
