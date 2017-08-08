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
            $table->integer('action_id');
            $table->integer('event_id');
            $table->string('name', 200);
            $table->timestamp('date');
            $table->text('description');
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
