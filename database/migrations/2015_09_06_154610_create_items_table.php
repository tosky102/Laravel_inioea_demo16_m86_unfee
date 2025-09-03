<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('title')->nullable();
            $table->decimal('price', 10, 0)->default(0);
            $table->decimal('fee', 10, 0)->default(0);
            $table->integer('quantity')->default(0);

            $table->string('category');
            $table->text('description')->nullable();
            $table->text('message')->nullable();

            $table->string('file_name')->nullable();

            $table->integer('sale_count')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('public_flag')->default(1);

            $table->string('password')->nullable();

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
        Schema::dropIfExists('items');
    }
}
