<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentsLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('description')->comment('Описание действия');
            $table->string('payment_sum', 50);
            $table->string('payment_number', 50);
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
        Schema::dropIfExists('payments_logs');
    }
}
