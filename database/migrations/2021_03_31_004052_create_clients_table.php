<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();            
            $table->string('comment',255)->nullable();
            $table->boolean('account')->default(false);
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->integer('clientprofile_id')->unsigned();
            $table->integer('credit')->unsigned();
            $table->string('status')->default('unused');
            $table->integer('limit-uptime')->unsigned();
            $table->integer('used-uptime')->nullable();
            $table->integer('autodelete_counter')->default(0);
            $table->integer('limit-bytes')->unsigned();
            $table->integer('used-bytes')->nullable();
            $table->macAddress('mac')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('cookie')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
