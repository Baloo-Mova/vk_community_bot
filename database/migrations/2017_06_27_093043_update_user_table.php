<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('vk_token');
            $table->integer('vk_id');
            $table->integer('expiresIn');
            $table->string('avatar');
            $table->string('FIO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('vk_token');
            $table->dropColumn('vk_id');
            $table->dropColumn('expiresIn');
            $table->dropColumn('avatar');
            $table->dropColumn('FIO');
        });
    }
}
