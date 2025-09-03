<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashing_data', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->decimal('money', 11, 0)->nullable();
            $table->decimal('fee', 11, 0)->default(0);
            $table->decimal('balance', 11, 0)->default(0);
            $table->date('apply_date')->nullable();

            $table->tinyInteger('status')->default(0);

            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('deposit_name')->nullable();

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
        Schema::dropIfExists('cashing_data');
    }
}
