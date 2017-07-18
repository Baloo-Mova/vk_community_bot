<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Funnels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funnels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('group_id');
        });
        Schema::create('funnels_time', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('funell_id');
            $table->integer('time');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funnels');
        Schema::dropIfExists('funnels_time');
    }
}
