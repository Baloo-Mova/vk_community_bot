<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelegramInUsergroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_groups',function(Blueprint $table){
            $table->string('telegram')->nullable();
            $table->boolean('send_to_telegram')->default(0);
            $table->text('moderator_events')->nullable();
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
            $table->dropColumn('telegram');
            $table->dropColumn('send_to_telegram');
            $table->dropColumn('moderator_events');
        });
    }
}
