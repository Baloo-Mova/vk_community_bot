<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_id');
            $table->string('name');
            $table->string('auto_add_key');
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_group_id');
            $table->integer('vk_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_groups');
        Schema::dropIfExists('clients');
    }
}
