<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('service_id')->references('id')->on('services');
            $table->string('order_no')->nullable();
            $table->string('order_type')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->boolean('available')->nullable();
            $table->boolean('booking')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
