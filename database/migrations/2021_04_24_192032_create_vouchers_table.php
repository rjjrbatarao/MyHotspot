<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('status')->default('unused');
            $table->string('comment',255)->nullable();
            $table->integer('credit')->unsigned();
            $table->integer('limit-uptime')->unsigned();
            $table->integer('limit-bytes')->unsigned();
            $table->integer('clientprofile_id')->unsigned();
            $table->integer('ordernumber_id')->unsigned();
            $table->string('created_by')->nullable();
            $table->string('created_from')->nullable();// retailer ,admin ,voucher, satellite
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
        Schema::dropIfExists('vouchers');
    }
}
