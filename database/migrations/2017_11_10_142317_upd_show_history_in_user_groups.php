<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdShowHistoryInUserGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_groups',function(Blueprint $table){
            $table->boolean('show_in_history')->default(0)->change();
            $table->integer('server_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_groups',function(Blueprint $table){
            $table->boolean('show_in_history')->change();
            $table->integer('server_id')->change();
        });
    }
}
