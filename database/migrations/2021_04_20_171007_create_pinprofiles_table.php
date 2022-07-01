<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinprofiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->integer('signal_pin')->unsigned(); // coin slot signal pim
            $table->integer('coincut_pin')->unsigned(); // coin cut pin
            $table->integer('button_pin')->unsigned(); // button queue pin
            $table->integer('charging_pin')->unsigned(); // charging pin      
            $table->integer('billacceptor_pin')->unsigned(); // bill pin no need buzzer since already has sounds
            $table->string('billcut_logic')->default('high');             
            $table->string('coincut_logic')->default('high'); // shared with bill acceptor            
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
        Schema::dropIfExists('pinprofiles');
    }
}
