<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusDateFieldsToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->datetime('started_at')->after('suggested_at')->nullable();
            $table->datetime('requested_at')->after('started_at')->nullable();
            $table->datetime('completed_at')->after('requested_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('completed_at');
            $table->dropColumn('requested_at');
            $table->dropColumn('started_at');
        });
    }
}
