<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_groups',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->integer('group_id');
            $table->integer('expiries');
            $table->string('token');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_groups');
    }
}
