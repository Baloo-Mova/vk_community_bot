<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeratorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderator_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('action_id')->nullable();
            $table->string('event_id');
            $table->integer('vk_id');
            $table->string('name', 200)->nullable();
            $table->timestamp('date')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderator_logs');
    }
}
