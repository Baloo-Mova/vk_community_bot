<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_community_response', function (Blueprint $table){
            $table->string('action_id')->nullable();
            $table->integer('add_group_id')->nullable();
        });

        Schema::table('mass_delivery', function(Blueprint $tab){
            $tab->timestamp('when_send');
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
