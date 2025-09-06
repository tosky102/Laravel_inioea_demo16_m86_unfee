<?php


namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopController extends AdminController
{
    protected function title()
    {
        return trans('admin.shop');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $shopModel = config('admin.database.shops_model');
        $grid = new Grid(new $shopModel());
        $grid->model()->whereHas('user', function($q) {
            $q->where('type', 0);
        });
        

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', trans('admin.user_name'));
        $grid->column('email', trans('admin.email'));
        $grid->column('created_at', trans('admin.created_at'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });

        $grid->disableCreateButton();
        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $userModel = config('admin.database.shops_model');
        $form = new Form(new $userModel);


        $form->display('id', 'ID');
        $form->select('user_id', trans('ItemUser'))->options(User::all()->pluck('email', 'id'))->rules('required');

        $arrItemStatus = config('constants.arrSelling');
        $form->select('status', trans('ItemStatus'))->options($arrItemStatus)->rules('required');

        $form->display('email', trans('Email'));

        // $arrCategory = config('constants.arrCategory');
        // $retCategory = [];
        // foreach ($arrCategory as $k => $categories) {
        //     foreach ($categories as $category => $val) {
        //         $retCategory[$category] = $category;
        //     }
        // }

        // $form->select('category', trans('ItemCategory'))->options($retCategory)->rules('required');

        $form->text('title', trans('Shop Title'))->rules('required|max:100');
        $form->text('business_name', trans('Shop Business Name'))->rules('required|max:100');
        $form->text('phone', trans('User Phone'))->rules('required|max:100');

        $prefs = json_decode(File::get(public_path('pref.json')), true);
        $prefs = array_column($prefs, 'name', 'id');
        $form->select('address1', trans('User Prefecture'))->options($prefs)->rules('required');
        $form->text('address2', trans('User City'))->rules('required|max:100');
        $form->text('address3', trans('User Address'))->rules('max:100');
        $form->text('station', trans('User Station'))->rules('max:100');
        $wages = [];
        for ($i = 1000; $i <= 3000; $i+=100) {
            $wages[$i] = $i;
        }
        $form->select('wage', trans('User Wage'). '(円以上)')->options($wages);

        $arrEmployments = config('constants.arrEmployments');
        $form->checkbox('employment', trans('Shop Employment'))->options($arrEmployments);
        
        $form->textarea('employment2', trans('Shop Other Employment'));
        $arrCareers = config('constants.arrCareers');
        $form->checkbox('career', trans('Shop Career'))->options($arrCareers);
        

        $form->textarea('career2', trans('Shop Other Career'));

        $form->text('password', trans('Password'))->rules('max:100');
        //        $form->decimal('fee', trans('ItemFee'));
        //        $form->number('quantity', trans('ItemQuantity'));

        $form->textarea('content', trans('Shop Content'));
        $form->textarea('image', trans('Shop Image'));
        $form->textarea('feature', trans('Shop Feature'));
        $form->textarea('appeal_point', trans('Shop AppealPoint'));
        $form->text('youtube', trans('Shop Youtube'));
        $form->text('website', trans('Shop WEBsite'));
        $form->text('sns1', trans('Shop Other SNS'));
        $form->text('sns2', trans('Shop Other SNS'));

        //        $form->hasMany('images', trans('ItemImage'), function (Form\NestedForm $nestedForm) {
        ////            var_dump($nestedForm->model()->item_id);
        //            $nestedForm->image('name', trans('ItemImage'))->move( function($nestedForm){ return 'items/'. $nestedForm->model()->id; })->name(function ($file) { return md5(uniqid()) . '.jpg'; })->thumbnail('', $width = 800, $height = 800);
        //        });
        $form->hasMany('images', trans('ItemImage'), function (Form\NestedForm $nestedForm) {
            //            var_dump($nestedForm->model()->item_id);
            $nestedForm->image('name', trans('ItemImage'))->move(function ($nestedForm) {
                return 'items/' . $nestedForm->model()->id;
            })->name(function ($file) {
                return md5(uniqid()) . '.jpg';
            })->thumbnail('', $width = 800, $height = 800);
        });
        
        // $form->multipleImage('images', trans('ItemImage'))->pathColumn('name')->removable()->rules('required')->move(function ($form) {
        //     return 'items/' . $form->model()->id;
        // })->name(function ($file) {
        //     return md5(uniqid()) . '.jpg';
        // })->thumbnail('', $width = 800, $height = 800);

        //        $form->text('tags.0.name', trans('ItemTagName'));
        //        $form->text('tags.1.name', trans('ItemTagName'));
        //        $form->text('tags.2.name', trans('ItemTagName'));
        //        $form->text('tags.3.name', trans('ItemTagName'));
        //        $form->text('tags.4.name', trans('ItemTagName'));
        $form->hasMany('tags', trans('ItemTags'), function (Form\NestedForm $form) {
            $form->text('name', trans('ItemTagName'));
        });

        $form->file('file_name', trans('ItemFileName'))->move(function ($form) {
            return 'files/' . $form->model()->id;
        });
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });
        return $form;
    }

    public function detail($id)
    {
        $userModel = config('admin.database.front_users_model');
        $user = $userModel::findOrFail($id);

        $show = new Show($user);
        $show->field('id', 'ID');

        $show->field('image_file_name', trans('ItemImage'))->image();



        $show->field('name', trans('Name'));
        $show->field('name_kana', trans('NameKana'));
        $show->field('company', trans('Company'));
        $show->field('postcode', trans('Postcode'));
        $show->field('address', trans('Address'));
        $show->field('phone', trans('Phone'));
        $show->field('gender_name', trans('Gender'));
        $show->field('birthday', trans('Birthday'));
        $show->field('nickname', trans('Nickname'));
        $show->field('comment', trans('ProfileComment'));
        $show->field('email', trans('E-Mail Address'));
        $show->field('password_hint', trans('Password Hint'));
        $show->field('point', trans('Point'));
        $show->field('mailmag_flag_text', trans('Mail Magazine'));


        //
        $show->field('bank_name', trans('Bank Name'));
        $show->field('branch_name', trans('Branch Name'));
        $show->field('branch_code', trans('Branch Code'));
        $show->field('account_no', trans('Account No'));
        $show->field('deposit_name', trans('Deposit Name'));

        $show->field('notification_to_seller_flag_text', trans('noticeMailFavorite'));
        $show->field('purchased_to_seller_flag_text', trans('noticeMailPurchase'));
        $show->field('status_text', trans('User Status'));
        $show->field('admin_message', trans('Admin Message'));


        return $show;
    }
}
