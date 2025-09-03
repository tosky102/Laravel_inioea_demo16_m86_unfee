<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'code' => 'cashing_rate', 'name' => '換金手数料率', 'unit_name' => 'パーセント', 'type' => '数値', 'number' => 30.00
        ]);
        DB::table('configs')->insert([
            'code' => 'min_change_money', 'name' => '最低換金額', 'unit_name' => '円', 'type' => '数値', 'number' => 1000.00
        ]);
        DB::table('configs')->insert([
            'code' => 'upload_file_size', 'name' => 'アップロードファイル上限', 'unit_name' => 'M', 'type' => '数値', 'number' => 2.00
        ]);
        DB::table('configs')->insert([
            'code' => 'upload_item_image_size', 'name' => '求人アップロード画像上限', 'unit_name' => 'M', 'type' => '数値', 'number' => 3.00
        ]);
        DB::table('configs')->insert([
            'code' => 'upload_user_image_size', 'name' => 'ユーザーアップロード画像上限', 'unit_name' => 'M', 'type' => '数値', 'number' => 2.00
        ]);
        DB::table('configs')->insert([
            'code' => 'sale_fee_rate', 'name' => '販売手数料', 'unit_name' => '％', 'type' => '数値', 'number' => 10.00
        ]);
    }
}