<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupTasksTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_community_response_time', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->integer('bot_community_response_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_community_response_time');
    }
}
