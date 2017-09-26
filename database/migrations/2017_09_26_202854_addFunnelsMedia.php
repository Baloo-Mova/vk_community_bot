<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFunnelsMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funnels_time', function (Blueprint $table) {
            $table->text('media');
        });

        Schema::table('auto_delivery', function(Blueprint $table){
            $table->text('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funnels_time', function (Blueprint $table) {
            $table->dropColumn('media');
        });

        Schema::table('auto_delivery', function(Blueprint $table){
            $table->dropColumn('media');
        });
    }
}
