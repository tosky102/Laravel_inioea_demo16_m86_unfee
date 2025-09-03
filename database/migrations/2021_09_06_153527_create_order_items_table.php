<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
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

            $table->integer('status')->default(0);

            $table->unsignedBigInteger('item_id');
            $table->string('title')->nullable();
            $table->decimal('price', 10, 0)->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('total', 10, 0)->default(0);
            $table->decimal('sale_fee', 10, 0)->default(0);

            $table->string('sale_ym')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->nullable()->on('items')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
