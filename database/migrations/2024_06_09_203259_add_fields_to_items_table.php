<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('wage')->nullable();
            $table->text('image')->nullable();
            $table->text('feature')->nullable();
            $table->text('appeal_point')->nullable();
            $table->string('website')->nullable();
            $table->string('youtube')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->string('station')->nullable();
            $table->string('employment')->nullable();
            $table->string('work_times')->nullable();
            $table->string('duration')->nullable();
            $table->string('timetable')->nullable();
            $table->text('content')->nullable();
            $table->string('resuraunt_years')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
