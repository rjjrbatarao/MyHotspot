<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientportalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientportals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('comment',255)->nullable();
            $table->string('status')->default('unassigned');
            $table->boolean('enable_trial')->default(false);// disabled trial
            $table->integer('trial_uptime')->unsigned();
            $table->string('trial_btntext')->default('trial');
            $table->boolean('enable_terms')->default(false);
            $table->boolean('enable_chat')->default(false);
            $table->boolean('enable_membership')->default(true);
            $table->boolean('enable_bgimage')->default(false);// this is toggle type
            $table->boolean('enable_eloading')->default(false);// this is toggle type
            $table->string('eload_btntext')->default('Eloading'); // its here because of unique service method
            $table->integer('eloadingprofile_id')->nullable()->unsigned();
            $table->string('bgimage')->nullable(); // show this when enab le bgiamge true
            $table->string('bgcolor')->default('info');// hide or show this 
            $table->boolean('enable_banner')->dafault(false);
            $table->boolean('enable_presound')->default(false); //toggle
            $table->string('presound_dir')->nullable();
            $table->boolean('enable_actvsound')->default(false); //toggle
            $table->string('actvsound_dir')->nullable();
            $table->boolean('enable_postsound')->default(false); //toggle
            $table->string('postsound_dir')->nullable();
            $table->text('usage_terms')->nullable();
            $table->string('title')->nullable();
            $table->string('footer')->nullable();
            $table->string('footer_url')->nullable();
            $table->integer('banner_interval')->unsigned()->default(3);
            $table->json('banners')->nullable();//upload as pictures
            $table->json('btn_satellite')->nullable();// select and order
            $table->boolean('enable_slidingbanner')->default(false);// this is toggle type
            $table->text('slidingbanner_text')->nullable();
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
        Schema::dropIfExists('clientportals');
    }
}
