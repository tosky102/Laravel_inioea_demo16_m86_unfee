<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCareerFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('career_1')->after('career_url_1')->nullable();
            $table->string('career_2')->after('career_url_2')->nullable();
            $table->string('career_3')->after('career_url_3')->nullable();
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
            $table->dropColumn('career_1');
            $table->dropColumn('career_2');
            $table->dropColumn('career_3');
        });
    }
}
