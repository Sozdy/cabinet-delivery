<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table)
        {
            //Через другую таблицу реализуется связь с действиями
            $table->id('id');
            $table->date('date');
            $table->date('previous_date')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('brigade_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('organization_name');
            $table->string('organization_address');
            $table->boolean('is_region');
            $table->string('contact_person');
            $table->string('phone');
            $table->string('comment');
            $table->boolean('is_paid');
            $table->boolean('is_available');
            $table->string('account');
            $table->string('selling');
            $table->integer('value');
            $table->foreignId('delivery_state_id');
			
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('brigade_id')->references('id')->on('brigades');
            $table->foreign('delivery_state_id')->references('id')->on('delivery_states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
