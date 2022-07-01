<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalconfigs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->integer('adapter_id')->unsigned();/// filter if wan wanif global interface
            $table->string('ntp_primary')->nullable();
            $table->string('ntp_secondary')->nullable();
            $table->string('hostname')->nullable();
            $table->boolean('advance_mode')->default(false);
            $table->boolean('enable_remote')->default(false);
            $table->string('remote_url')->nullable();//ngrok
            $table->string('license')->nullable();
            $table->string('email')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longtitude')->nullable();
            $table->integer('zoom')->unsigned()->default(20);
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
        Schema::dropIfExists('generalconfigs');
    }
}
