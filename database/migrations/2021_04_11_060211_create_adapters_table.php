<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdaptersTable extends Migration
{
    /**
     * Run the migrations. creatable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adapters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('uuid')->nullable();
            $table->string('type')->nullable();
            $table->string('mode')->nullable();// wan or lan
            $table->string('status')->default('unassigned');
            $table->integer('device_id')->nullable();
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
        Schema::dropIfExists('adapters');
    }
}
