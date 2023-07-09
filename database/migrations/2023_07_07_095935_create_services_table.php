<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('experience')->nullable();
            $table->string('service_type')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('service_price')->nullable();
            $table->float('rating')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->boolean('recommended')->default(false);
            $table->boolean('trending')->default(false);
            $table->bigInteger('view_count')->default(0);
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
        Schema::dropIfExists('services');
    }
}
