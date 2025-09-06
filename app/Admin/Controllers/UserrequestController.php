<?php

namespace App\Admin\Controllers;

use App\Models\AdminConfirm;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class UserrequestController extends AdminController
{
    protected function title()
    {
        return '承認一覧';
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $uri = 'userrequest';
        AdminConfirm::updateOrCreate(['uri' => $uri], ['confirmed_at' => now()]);

        /** @var \App\Models\User $requestModel */
        $requestModel = config('admin.database.front_users_model');
        $grid = new Grid(new $requestModel());
        
        $grid->column('id', 'ID')->sortable();
        $grid->column('name', trans('admin.user_name'));
        $grid->column('email', trans('admin.email'));
        $grid->column('role', trans('admin.permissions'))->display(function ($role) {
            return $role == 'influencer' ? trans('admin.influencer') : trans('admin.company');
        });
        $grid->column('created_at', trans('admin.userrequest_date'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        
        $grid->disableCreateButton();
        $grid->disableColumnSelector();

        $grid->model()->where('status', 2)->orderBy('created_at', 'desc');
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        /** @var \App\Models\User $userModel */
        $userModel = config('admin.database.front_users_model');
        $form = new Form(new $userModel);

        $form->display('id', 'ID');
        $form->display('name', trans('Name'));
        $form->display('role', trans('admin.permissions'))->with(function ($role) {
            return $role == 'influencer' ? trans('admin.influencer') : trans('admin.company');
        });
        $form->display('email', trans('E-Mail Address'));
        $form->display('password_hint', trans('Password Hint'));
        $form->select('status', trans('admin.userrequest_status'))->options([
            2 => '承認待ち',
            3 => '承認済み',
        ]);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        return $form;
    }
}
