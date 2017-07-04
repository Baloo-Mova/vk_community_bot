<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReplaceLastCheckedTimePlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bot_community_response', function (Blueprint $t) {
            $t->removeColumn('last_time_checked');
            $t->removeColumn('reserved');
        });

        Schema::table('user_groups', function (Blueprint $t) {
            $t->timestamp('last_time_checked')->nullable();
            $t->boolean('status')->default(0)->comment('Включена или выключенна работа для группы');
            $t->boolean('payed')->default(0)->comment('Оплачена ли группа');
            $t->timestamp('payed_for')->nullable()->comment('До какого оплачена');
            $t->boolean('reserved')->default(0);
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
