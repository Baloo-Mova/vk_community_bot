<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BotCommunityResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_community_response', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('key', 255);
            $table->string('response', 255);
            $table->boolean('state')->default(1);
            $table->boolean('reserved')->default(0);
            $table->timestamp('last_time_checked')->comment('Время последнего изменения');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bot_community_response');
    }
}
