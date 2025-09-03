<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('api_type');
            $table->string('token');
            $table->string('response_id');
            $table->string('error_code')->nullable();
            $table->decimal('money', 12, 2);;

            $table->tinyInteger('test_flag')->default(0);
            $table->tinyInteger('status')->default(0);

            $table->datetime('transaction_time');
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
        Schema::dropIfExists('credit_transactions');
    }
}
