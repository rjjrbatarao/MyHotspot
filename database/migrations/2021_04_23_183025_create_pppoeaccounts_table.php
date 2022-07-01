<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePppoeaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pppoeaccounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment',255)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('block_number')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('subdivision')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('house_number')->nullable();
            $table->string('secondary_address')->nullable();
            $table->string('others')->nullable();
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
        Schema::dropIfExists('pppoeaccounts');
    }
}
