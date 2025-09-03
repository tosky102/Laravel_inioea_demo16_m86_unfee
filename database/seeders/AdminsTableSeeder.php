<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu')->truncate();
        DB::table('admin_permissions')->truncate();
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_users')->truncate();
        DB::table('admin_roles')->truncate();
        DB::table('admin_users')->truncate();
        
        DB::table('admin_menu')->insert([
            'id' => 2, 'parent_id' => 0, 'order' => 94, 'title' => '管理', 'icon' => 'fa-tasks',
        ]);
        DB::table('admin_menu')->insert([
            'id' => 3, 'parent_id' => 2, 'order' => 95, 'title' => '管理者', 'icon' => 'fa-users', 'uri' => 'auth/users'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 4, 'parent_id' => 2, 'order' => 96, 'title' => '役割', 'icon' => 'fa-user', 'uri' => 'auth/roles'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 5, 'parent_id' => 2, 'order' => 97, 'title' => '権限', 'icon' => 'fa-ban', 'uri' => 'auth/permissions'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 6, 'parent_id' => 2, 'order' => 98, 'title' => 'メニュー', 'icon' => 'fa-bars', 'uri' => 'auth/menu'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 7, 'parent_id' => 2, 'order' => 99, 'title' => 'ログー', 'icon' => 'fa-history', 'uri' => 'auth/logs'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 8, 'parent_id' => 0, 'order' => 1, 'title' => 'ダッシュボード', 'icon' => 'fa-tachometer', 'uri' => ''
        ]);
        DB::table('admin_menu')->insert([
            'id' => 9, 'parent_id' => 0, 'order' => 2, 'title' => 'インフルエンサー', 'icon' => 'fa-user', 'uri' => 'user'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 10, 'parent_id' => 0, 'order' => 3, 'title' => '企業(宿泊施設)一覧', 'icon' => 'fa-users', 'uri' => 'company'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 11, 'parent_id' => 0, 'order' => 4, 'title' => '承認一覧', 'icon' => 'fa-user-plus', 'uri' => 'userrequest'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 12, 'parent_id' => 0, 'order' => 5, 'title' => '案件一覧', 'icon' => 'fa-paperclip', 'uri' => 'item'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 13, 'parent_id' => 0, 'order' => 6, 'title' => '取引一覧', 'icon' => 'fa-briefcase', 'uri' => 'orderitem'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 14, 'parent_id' => 0, 'order' => 7, 'title' => 'カテゴリー', 'icon' => 'fa-list-ul', 'uri' => 'category'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 15, 'parent_id' => 0, 'order' => 8, 'title' => '定型文', 'icon' => 'fa-pencil-square-o', 'uri' => 'template'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 16, 'parent_id' => 0, 'order' => 9, 'title' => 'レビュー', 'icon' => 'fa-comment-o', 'uri' => 'review'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 17, 'parent_id' => 0, 'order' => 10, 'title' => 'データ分析', 'icon' => 'fa-bar-chart', 'uri' => 'analysis'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 18, 'parent_id' => 0, 'order' => 11, 'title' => 'お問い合わせ', 'icon' => 'fa-question-circle', 'uri' => 'contact'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 19, 'parent_id' => 0, 'order' => 12, 'title' => 'お知らせ', 'icon' => 'fa-bullhorn', 'uri' => 'notification'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 20, 'parent_id' => 0, 'order' => 13, 'title' => '設定値', 'icon' => 'fa-cog', 'uri' => 'config'
        ]);
        DB::table('admin_menu')->insert([
            'id' => 21, 'parent_id' => 0, 'order' => 14, 'title' => 'ページ編集', 'icon' => 'fa-html5', 'uri' => 'htmlpart'
        ]);

        DB::table('admin_permissions')->insert([
            'id' => 1, 'name' => 'All permission', 'slug' => '*', 'http_method' => '', 'http_path' => '*'
        ]);
        DB::table('admin_permissions')->insert([
            'id' => 2, 'name' => 'Dashboard', 'slug' => 'dashboard', 'http_method' => 'GET', 'http_path' => '/'
        ]);
        DB::table('admin_permissions')->insert([
            'id' => 3, 'name' => 'Login', 'slug' => 'auth.login', 'http_method' => '', 'http_path' => '/auth/login\r\n/auth/logout'
        ]);
        DB::table('admin_permissions')->insert([
            'id' => 4, 'name' => 'User setting', 'slug' => 'auth.setting', 'http_method' => 'GET,PUT', 'http_path' => '/auth/setting'
        ]);
        DB::table('admin_permissions')->insert([
            'id' => 5, 'name' => 'Auth management', 'slug' => 'auth.management', 'http_method' => '', 'http_path' => '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs'
        ]);

        DB::table('admin_role_menu')->insert([
            'role_id' => 1, 'menu_id' => 2
        ]);

        DB::table('admin_role_permissions')->insert([
            'role_id' => 1, 'permission_id' => 1
        ]);

        DB::table('admin_role_users')->insert([
            'role_id' => 1, 'user_id' => 1
        ]);

        DB::table('admin_roles')->insert([
            'id' => 1, 'name' => 'Administrator', 'slug' => 'administrator'
        ]);

        DB::table('admin_users')->insert([
            'id' => 1, 'username' => 'admin', 'password' => '$2y$10$cR0oNQ.8RUc0H7VuK98H7.dO5ATyZCy6XgwG.UbYiDd6wTx56VlPC', 'name' => 'サイト管理者', 'remember_token' => 'x0v2e0Zt2XkXOiboBOiEFBwWWDOgixZzufPNU3Di3nUq2Ad9hKz4fxlRr5gV'
        ]);
    }
}