<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('address');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('districts')->onDelete('cascade');
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->string('note')->nullable();
            $table->string('phone')->nullable();
            $table->integer('total')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('payment_method');
            $table->string('payment');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('coupon_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
