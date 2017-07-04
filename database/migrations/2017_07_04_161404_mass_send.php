<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MassSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mass_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->text('rules');
            $table->text('message');
            $table->boolean('reserved')->default(0);
            $table->boolean('sended')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mass_delivery');
    }
}
