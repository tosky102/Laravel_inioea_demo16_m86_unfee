 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_kana')->nullable();
            $table->string('company')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('birthday')->nullable();
            $table->string('nickname')->nullable();

            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('password_hint')->nullable();
            $table->integer('mailmag_flag')->default(0);

            $table->text('comment')->nullable();
            $table->text('admin_message')->nullable();
            $table->integer('point')->default(0);

            $table->string('image_file_name')->nullable();
            $table->string('user_rank')->default('general');
            $table->string('role')->default('user')->comment('user:一般 admin:管理者 dev:開発者');
            $table->integer('status')->default(0)->comment('0:仮登録 1:有効 2:投稿不可 3:閲覧不可');

            $table->decimal('admin_level', 2, 1)->nullable();

            $table->integer('sale_count')->default(0);

            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('deposit_name')->nullable();

            $table->tinyInteger('notification_to_seller_flag')->default(1)->comment('0:送信しない　1:送信する');
            $table->tinyInteger('purchased_to_seller_flag')->default(1)->comment('0:送信しない　1:送信する');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
