<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions_invoked', function(Blueprint $table){
            $table->dropIndex('actions_invoked_key_index');
            $table->dropColumn('count');
            $table->dateTime('time')->nullable();
            $table->index([
                'bot_community_response_id',
                'time'
            ]);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
