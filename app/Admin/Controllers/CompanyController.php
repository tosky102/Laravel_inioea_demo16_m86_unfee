<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class CompanyController extends AdminController
{
    protected function title()
    {
        return trans('admin.company');
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
        $grid->column('name', trans('admin.company'));
        $grid->column('email', trans('admin.email'));
        $grid->column('status_text', trans('admin.userrequest_status'));
        $grid->column('created_at', trans('admin.created_at'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        $grid->column('impersonate', 'なりすましログイン')->display(function () {
            /** @var \App\Models\Company $this */
            return "<a href='/impersonate/{$this->id}' target='_blank'><i class='fa fa-external-link' style='margin-right: 4px; margin-top: 4px;'></i>なりすましログイン</a>";
        });

        $grid->model()->where('role', 'company')->orderBy('created_at', 'desc');

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

        // 都道府県・市区町村データを読み込み
        $prefJsonPath = public_path('pref.json');
        $prefsData = [];
        $prefOptions = [];
        $cityOptions = [];
        
        if (file_exists($prefJsonPath)) {
            $prefsData = json_decode(file_get_contents($prefJsonPath), true);
            
            // 都道府県の配列を作成
            foreach ($prefsData as $prefId => $pref) {
                $prefOptions[$prefId] = $pref['name'];
            }
            
            // 市区町村の配列を作成
            foreach ($prefsData as $prefId => $pref) {
                $cityOptions[$prefId] = [];
                foreach ($pref['city'] as $city) {
                    $cityOptions[$prefId][$city['citycode']] = $city['city'];
                }
            }
        }

        // メインカテゴリーの配列
        $mainCategories = Category::whereDoesntHave('parent')->pluck('name', 'id')->toArray();
        $arrEmployeeCount = config('constants.arrEmployeeCount');
        $arrEarning = config('constants.arrEarning');

        $form->display('id', 'ID');
        $form->multipleImage('images', trans('ItemImage'))->pathColumn('name')->removable()->move(function ($form) {
            return 'users/' . $form->model()->id;
        })->name(function ($file) {
            return md5(uniqid()) . '.jpg';
        })->thumbnail('', $width = 800, $height = 800);
        $form->text('email', trans('admin.email'))->rules('required');
        $form->password('password', trans('Password'))->rules('required|max:100');
        $form->text('password_hint', trans('Password Hint'))->rules('nullable|max:100');
        $form->text('name', trans('admin.company_name'))->rules('required');
        $form->text('facility_name', trans('admin.facility_name'))->rules('required');
        $form->text('postcode', trans('admin.postcode'))->rules('required');
        $form->select('pref', trans('admin.pref'))->options($prefOptions)->rules('required');
        $form->select('city', trans('admin.city'))->options([])
            ->attribute(['data-value' => old('city', $form->model()->city ?? '')])->rules('required');
        $form->text('address', trans('admin.address'));
        $form->select('main_category', trans('admin.company_main_category'))->options($mainCategories)->rules('required');
        $form->text('manager_name', trans('admin.manager_name'));
        $form->text('manager_position', trans('admin.manager_position'));
        $form->text('manager_phone', trans('admin.manager_phone'));
        $form->select('employee_count', trans('admin.employee_count'))->options($arrEmployeeCount)->rules('required');
        $form->select('earning', trans('admin.earning'))->options($arrEarning)->rules('required');
        $form->textarea('comment', trans('admin.profile_comment'))->rules('required');
        $form->textarea('career', trans('admin.career'))->rules('required');
        $form->text('company_qualification', trans('admin.qualification'))->rules('required');
        $form->text('specialty', trans('admin.specialty'))->rules('required');

        $form->hidden('status')->default(3);
        $form->hidden('role')->default('company');

        // カスケードセレクトボックスのJavaScript
        $cityOptionsJson = json_encode($cityOptions);
        $form->html("
            <script>
            $(document).ready(function() {
                var cityOptions = {$cityOptionsJson};
                
                $('select[name=\"pref\"]').on('change', function() {
                    var prefId = $(this).val();
                    var citySelect = $('select[name=\"city\"]');
                    
                    // 市区町村をクリア
                    citySelect.empty().append('<option value=\"\">選択してください</option>');
                    
                    if (prefId && cityOptions[prefId]) {
                        // 対応する市区町村を追加
                        $.each(cityOptions[prefId], function(citycode, cityname) {
                            citySelect.append('<option value=\"' + cityname + '\">' + cityname + '</option>');
                        });
                    }
                });
                
                // 初期化時の設定（編集時）
                var initialPref = $('select[name=\"pref\"]').val();
                var initialCity = $('select[name=\"city\"]').data('value');
                
                if (initialPref && cityOptions[initialPref]) {
                    var citySelect = $('select[name=\"city\"]');
                    citySelect.empty().append('<option value=\"\">選択してください</option>');
                    
                    $.each(cityOptions[initialPref], function(citycode, cityname) {
                        var selected = (cityname == initialCity) ? 'selected' : '';
                        citySelect.append('<option value=\"' + cityname + '\" ' + selected + '>' + cityname + '</option>');
                    });
                }
            });
            </script>
        ");

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
        /** @var \App\Models\User $userModel */
        $userModel = config('admin.database.front_users_model');
        $user = $userModel::findOrFail($id);

        $show = new Show($user);
        $show->field('id', 'ID');
        $show->field('name', trans('admin.company_name'));
        $show->field('facility_name', trans('admin.facility_name'));
        $show->field('postcode', trans('admin.postcode'));
        $show->field('pref', trans('admin.pref'));
        $show->field('city', trans('admin.city'));
        $show->field('address', trans('admin.address'));
        $show->field('main_category', trans('admin.company_main_category'));
        $show->field('manager_name', trans('admin.manager_name'));
        $show->field('manager_position', trans('admin.manager_position'));
        $show->field('manager_phone', trans('admin.manager_phone'));
        $show->field('employee_count', trans('admin.employee_count'));
        $show->field('earning', trans('admin.earning'));
        $show->field('comment', trans('admin.profile_comment'));
        $show->field('career', trans('admin.career'));
        $show->field('qualification', trans('admin.qualification'));
        $show->field('specialty', trans('admin.specialty'));

        return $show;
    }
}
