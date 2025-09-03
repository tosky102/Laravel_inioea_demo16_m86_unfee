<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1: 応募返信定型文, 2: 依頼定型文, 3: お見送りの文章, 4: 採用お礼定型文, 5: 来店お礼定型文, 6: 投稿完了定型文');
            $table->text('template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_templates');
    }
}
