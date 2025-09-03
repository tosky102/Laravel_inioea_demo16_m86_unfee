<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('name_kana')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('postcode')->nullable();
            $table->string('pref')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment')->nullable();
            $table->integer('point')->default(0);
            $table->text('comment')->nullable();
            $table->integer('rank')->default(0);
            $table->integer('status')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_points');
    }
}
