<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFanCountNullableToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('instagram_fan_count')->nullable()->change();
            $table->unsignedBigInteger('tiktok_fan_count')->nullable()->change();
            $table->unsignedBigInteger('x_fan_count')->nullable()->change();
            $table->unsignedBigInteger('youtube_fan_count')->nullable()->change();
            $table->unsignedBigInteger('facebook_fan_count')->nullable()->change();
            $table->unsignedBigInteger('other_fan_count')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('instagram_fan_count')->nullable(false)->change();
            $table->unsignedBigInteger('tiktok_fan_count')->nullable(false)->change();
            $table->unsignedBigInteger('x_fan_count')->nullable(false)->change();
            $table->unsignedBigInteger('youtube_fan_count')->nullable(false)->change();
            $table->unsignedBigInteger('facebook_fan_count')->nullable(false)->change();
            $table->unsignedBigInteger('other_fan_count')->nullable(false)->change();
        });
    }
}
