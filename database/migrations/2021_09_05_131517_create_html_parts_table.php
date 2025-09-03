<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtmlPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_parts', function (Blueprint $table) {
            $table->id();
            $table->integer('file_flag')->default(0);
            $table->integer('file_name')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('desc')->nullable();

            $table->tinyInteger('public_flag')->default(1);
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
        Schema::dropIfExists('html_parts');
    }
}
