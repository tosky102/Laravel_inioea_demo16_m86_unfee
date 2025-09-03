<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfluenserFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('facility_name')->after('name_kana')->nullable();
            $table->string('main_category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('pref')->after('postcode')->nullable();
            $table->string('city')->after('pref')->nullable();
            $table->string('birthplace')->after('city')->nullable();
            $table->string('residence')->after('birthplace')->nullable();
            $table->string('manager_name')->after('password_hint')->nullable();
            $table->string('manager_position')->after('manager_name')->nullable();
            $table->string('manager_phone')->after('manager_position')->nullable();
            $table->string('area')->after('manager_phone')->nullable();
            $table->text('specialty')->after('area')->nullable();
            $table->text('hobby')->after('specialty')->nullable();
            $table->text('qualification')->after('hobby')->nullable();
            $table->string('company_qualification')->after('qualification')->nullable();
            $table->string('language')->after('company_qualification')->nullable();
            $table->string('instagram_account')->after('language')->nullable();
            $table->integer('instagram_fan_count')->after('instagram_account')->default(0);
            $table->string('tiktok_account')->after('instagram_fan_count')->nullable();
            $table->integer('tiktok_fan_count')->after('tiktok_account')->default(0);
            $table->string('x_account')->after('tiktok_fan_count')->nullable();
            $table->integer('x_fan_count')->after('x_account')->default(0);
            $table->string('youtube_account')->after('x_fan_count')->nullable();
            $table->integer('youtube_fan_count')->after('youtube_account')->default(0);
            $table->string('facebook_account')->after('youtube_fan_count')->nullable();
            $table->integer('facebook_fan_count')->after('facebook_account')->default(0);
            $table->string('other_account')->after('facebook_fan_count')->nullable();
            $table->integer('other_fan_count')->after('other_account')->default(0);
            $table->text('career')->after('other_fan_count')->nullable();
            $table->text('career_url_1')->after('career')->nullable();
            $table->text('career_url_2')->after('career_url_1')->nullable();
            $table->text('career_url_3')->after('career_url_2')->nullable();
            $table->string('employee_count')->after('career_url_3')->nullable();
            $table->string('earning')->after('employee_count')->nullable();
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
            $table->dropColumn('facility_name');
            $table->dropColumn('main_category');
            $table->dropColumn('sub_category');
            $table->dropColumn('pref');
            $table->dropColumn('city');
            $table->dropColumn('birthplace');
            $table->dropColumn('residence');
            $table->dropColumn('manager_name');
            $table->dropColumn('manager_position');
            $table->dropColumn('manager_phone');
            $table->dropColumn('area');
            $table->dropColumn('specialty');
            $table->dropColumn('hobby');
            $table->dropColumn('qualification');
            $table->dropColumn('company_qualification');
            $table->dropColumn('language');
            $table->dropColumn('instagram_account');
            $table->dropColumn('instagram_fan_count');
            $table->dropColumn('tiktok_account');
            $table->dropColumn('tiktok_fan_count');
            $table->dropColumn('x_account');
            $table->dropColumn('x_fan_count');
            $table->dropColumn('youtube_account');
            $table->dropColumn('youtube_fan_count');
            $table->dropColumn('facebook_account');
            $table->dropColumn('facebook_fan_count');
            $table->dropColumn('other_account');
            $table->dropColumn('other_fan_count');
            $table->dropColumn('career');
            $table->dropColumn('career_url_1');
            $table->dropColumn('career_url_2');
            $table->dropColumn('career_url_3');
            $table->dropColumn('employee_count');
            $table->dropColumn('earning');
        });
    }
}
