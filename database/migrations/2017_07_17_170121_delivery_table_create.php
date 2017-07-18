<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeliveryTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vk_id');
            $table->integer('client_group_id');
            $table->integer('group_id');
            $table->string('message');
            $table->integer('when_send');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_delivery');
    }
}
