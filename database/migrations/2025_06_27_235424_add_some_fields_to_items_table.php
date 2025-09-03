<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->tinyInteger('is_offering')->after('quantity')->default(1);
            $table->text('address')->after('description')->nullable();
            $table->string('post_sns')->after('address')->nullable();
            $table->string('post_type')->after('post_sns')->nullable();
            $table->string('hash_tag')->after('post_type')->nullable();
            $table->string('pr_account')->after('hash_tag')->nullable();
            $table->text('pr_flow')->after('pr_account')->nullable();
            $table->text('pr_rule')->after('pr_flow')->nullable();
            $table->text('condition')->after('pr_rule')->nullable();
            $table->string('entry_sns')->after('condition')->nullable();
            $table->string('entry_follower')->after('entry_sns')->nullable();
            $table->text('entry_method')->after('entry_follower')->nullable();
            $table->tinyInteger('is_emergency')->after('entry_method')->nullable();
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
            $table->dropColumn('is_offering');
            $table->dropColumn('address');
            $table->dropColumn('post_sns');
            $table->dropColumn('post_type');
            $table->dropColumn('hash_tag');
            $table->dropColumn('pr_account');
            $table->dropColumn('pr_flow');
            $table->dropColumn('pr_rule');
            $table->dropColumn('condition');
            $table->dropColumn('sns');
            $table->dropColumn('follower_count');
            $table->dropColumn('entry_method');
            $table->dropColumn('is_emergency');
        });
    }
}
