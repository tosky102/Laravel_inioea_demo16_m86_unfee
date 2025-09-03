<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnotherFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->string('employment2')->nullable();
            $table->string('career2')->nullable();
            $table->string('sns1')->nullable();
            $table->string('sns2')->nullable();
            $table->string('qualification')->nullable();
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
        });
    }
}
