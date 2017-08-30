<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cache',function(Blueprint $table){
            $table->increments('id');
            $table->integer('vk_id');
            $table->string('fname');
            $table->string('sname');
            $table->string('photo');
            $table->timestamp('when_remove');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
