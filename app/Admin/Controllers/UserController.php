<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    protected function title()
    {
        return trans('admin.user');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        /** @var \App\Models\User $userModel */
        $userModel = config('admin.database.front_users_model');
        $grid = new Grid(new $userModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', trans('admin.user_name'));
        $grid->column('email', trans('admin.email'));
        $grid->column('instagram_account', trans('admin.instagram_account'))->display(function ($instagram_account) {
            return $instagram_account ? '@' . $instagram_account : '-';
        });
        $grid->column('tiktok_account', trans('admin.tiktok_account'))->display(function ($tiktok_account) {
            return $tiktok_account ? '@' . $tiktok_account : '-';
        });
        $grid->column('x_account', trans('admin.x_account'))->display(function ($x_account) {
            return $x_account ? '@' . $x_account : '-';
        });
        $grid->column('youtube_account', trans('admin.youtube_account'))->display(function ($youtube_account) {
            return $youtube_account ? '@' . $youtube_account : '-';
        });
        $grid->column('facebook_account', trans('admin.facebook_account'))->display(function ($facebook_account) {
            return $facebook_account ? '@' . $facebook_account : '-';
        });
        $grid->column('created_at', trans('admin.created_at'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        $grid->column('impersonate', 'なりすましログイン')->display(function () {
            /** @var \App\Models\User $this */
            return "<a href='/impersonate/{$this->id}' target='_blank'><i class='fa fa-external-link' style='margin-right: 4px; margin-top: 4px;'></i>なりすましログイン</a>";
        });

        $grid->model()->where('role', 'influencer')->orderBy('created_at', 'desc');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        /** @var \App\Models\User $userModel */
        $userModel = config('admin.database.front_users_model');
        $form = new Form(new $userModel);

        $form->display('id', 'ID');
        $form->multipleImage('images', trans('ItemImage'))->pathColumn('name')->removable()->move(function ($form) {
            return 'users/' . $form->model()->id;
        })->name(function ($file) {
            return md5(uniqid()) . '.jpg';
        })->thumbnail('', $width = 800, $height = 800);
        $form->text('name', trans('admin.user_name'))->rules('required');
        $form->text('nickname', trans('admin.influencer_name'))->rules('required');
        $form->text('email', trans('admin.email'))->rules('required');
        // パスワードは管理画面で入力があればハッシュ化して保存。編集時は未入力で既存パスワードを維持
        $form->password('password', trans('Password'))->rules('required|max:100');
        $form->text('password_hint', trans('Password Hint'))->rules('nullable|max:100');
        
        // メインカテゴリーの配列を作成
        $mainCategories = Category::whereDoesntHave('parent')->pluck('name', 'id')->toArray();
        
        // サブカテゴリーの配列を作成
        // $subCategories = [];
        // foreach ($categoriesData as $category) {
        //     $subCategories[$category['id']] = [];
        //     foreach ($category['sub_categories'] as $subCategory) {
        //         $subCategories[$category['id']][$subCategory['id']] = $subCategory['name'];
        //     }
        // }

        $form->radio('gender', trans('admin.gender'))->options(config('constants.arrGenders'))->default(1);
        $form->select('main_category', trans('admin.main_category'))->options($mainCategories)->rules('required');
        // $form->select('sub_category', trans('admin.sub_category'))->options([])->rules('required')
        //     ->attribute(['data-value' => old('sub_category', $form->model()->sub_category ?? '')]);
        $form->text('birthplace', trans('admin.birthplace'));
        $form->text('residence', trans('admin.residence'));
        $arrAreas = config('constants.arrArea');
        $form->select('area', trans('admin.area'))->options($arrAreas)->rules('required');
        $form->textarea('specialty', trans('admin.specialty'));
        $form->textarea('hobby', trans('admin.hobby'));
        $arrLanguages = config('constants.arrLanguage');
        $form->select('language', trans('admin.language'))->options($arrLanguages)->rules('required');
        $form->textarea('comment', trans('admin.profile_comment'));
        $form->text('instagram_account', trans('admin.instagram_account'));
        $form->number('instagram_fan_count', trans('admin.instagram_fan_count'));
        $form->text('tiktok_account', trans('admin.tiktok_account'));
        $form->number('tiktok_fan_count', trans('admin.tiktok_fan_count'));
        $form->text('x_account', trans('admin.x_account'));
        $form->number('x_fan_count', trans('admin.x_fan_count'));
        $form->text('youtube_account', trans('admin.youtube_account'));
        $form->number('youtube_fan_count', trans('admin.youtube_fan_count'));
        $form->text('facebook_account', trans('admin.facebook_account'));
        $form->number('facebook_fan_count', trans('admin.facebook_fan_count'));
        $form->text('other_account', trans('admin.other_account'));
        $form->number('other_fan_count', trans('admin.other_fan_count'));
        $form->url('career_url_1', trans('admin.career_url'))->rules('nullable|url');
        $form->textarea('career_1', trans('admin.career'));
        $form->url('career_url_2', trans('admin.career_url'))->rules('nullable|url');
        $form->textarea('career_2', trans('admin.career'));
        $form->url('career_url_3', trans('admin.career_url'))->rules('nullable|url');
        $form->textarea('career_3', trans('admin.career'));

        // 運営担当者からの設定項目

        $form->switch('is_recommended', trans('admin.is_recommended'))->default(0);
        $form->switch('is_picked', trans('admin.is_picked'))->default(0);
        $form->checkbox('level', trans('admin.level'))->options(config('constants.arrInfluencerLevel'));
        $form->textarea('admin_comment', trans('admin.admin_comment'));
        $form->select('admin_pickup_category', trans('admin.admin_pickup_category'))->options($mainCategories);

        // ステータスを追加し、デフォルト値を 3 に設定
        $form->hidden('status')->default(3);
        $form->hidden('role')->default('influencer');

        // カスケードセレクトボックスのJavaScript
        // $subCategoriesJson = json_encode($subCategories);
        // $form->html("
        //     <script>
        //     $(document).ready(function() {
        //         var subCategories = {$subCategoriesJson};
                
        //         $('select[name=\"main_category\"]').on('change', function() {
        //             var mainCategoryId = $(this).val();
        //             var subCategorySelect = $('select[name=\"sub_category\"]');
                    
        //             // サブカテゴリーをクリア
        //             subCategorySelect.empty().append('<option value=\"\">選択してください</option>');
                    
        //             if (mainCategoryId && subCategories[mainCategoryId]) {
        //                 // 対応するサブカテゴリーを追加
        //                 $.each(subCategories[mainCategoryId], function(id, name) {
        //                     subCategorySelect.append('<option value=\"' + id + '\">' + name + '</option>');
        //                 });

        //                 // UI 更新（Select2 などの再描画）
        //                 // subCategorySelect.val('').trigger('change');
        //             }
        //         });
                
        //         // 初期化時の設定（編集時）
        //         var initialMainCategory = $('select[name=\"main_category\"]').val();
        //         var initialSubCategory = $('select[name=\"sub_category\"]').data('value');
                
        //         if (initialMainCategory && subCategories[initialMainCategory]) {
        //             var subCategorySelect = $('select[name=\"sub_category\"]');
        //             subCategorySelect.empty().append('<option value=\"\">選択してください</option>');
                    
        //             $.each(subCategories[initialMainCategory], function(id, name) {
        //                 var selected = (id == initialSubCategory) ? 'selected' : '';
        //                 subCategorySelect.append('<option value=\"' + id + '\" ' + selected + '>' + name + '</option>');
        //             });

        //             // 選択状態を設定して UI を更新
        //             // subCategorySelect.val(initialSubCategory).trigger('change');
        //         }
        //     });
        //     </script>
        // ");

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        // 保存時の処理：パスワードをハッシュ化（未入力なら既存値を維持）
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = Hash::make($form->password);
            } else {
                // 編集時に空のまま送られた場合は既存のパスワードを残す
                $form->password = $form->model()->password ?? null;
            }
        });

        return $form;
    }

    public function detail($id)
    {
        $userModel = config('admin.database.front_users_model');
        $user = $userModel::findOrFail($id);

        $show = new Show($user);
        $show->field('id', 'ID');

        $show->field('images', trans('ItemImage'))->image();
        $show->field('gender', trans('admin.gender'));
        $show->field('main_category', trans('admin.main_category'));
        $show->field('sub_category', trans('admin.sub_category'));
        $show->field('birthplace', trans('admin.birthplace'));
        $show->field('residence', trans('admin.residence'));
        $show->field('area', trans('admin.area'));
        $show->field('specialty', trans('admin.specialty'));
        $show->field('hobby', trans('admin.hobby'));
        $show->field('language', trans('admin.language'));
        $show->field('comment', trans('admin.profile_comment'));
        $show->field('instagram_account', trans('admin.instagram_account'));
        $show->field('instagram_fan_count', trans('admin.instagram_fan_count'));
        $show->field('tiktok_account', trans('admin.tiktok_account'));
        $show->field('tiktok_fan_count', trans('admin.tiktok_fan_count'));
        $show->field('x_account', trans('admin.x_account'));
        $show->field('x_fan_count', trans('admin.x_fan_count'));
        $show->field('youtube_account', trans('admin.youtube_account'));
        $show->field('youtube_fan_count', trans('admin.youtube_fan_count'));
        $show->field('facebook_account', trans('admin.facebook_account'));
        $show->field('facebook_fan_count', trans('admin.facebook_fan_count'));
        $show->field('other_account', trans('admin.other_account'));
        $show->field('other_fan_count', trans('admin.other_fan_count'));
        $show->field('career_url_1', trans('admin.career_url'));
        $show->field('career_1', trans('admin.career'));
        $show->field('career_url_2', trans('admin.career_url'));
        $show->field('career_2', trans('admin.career'));
        $show->field('career_url_3', trans('admin.career_url'));
        $show->field('career_3', trans('admin.career'));
        
        return $show;
    }
}
