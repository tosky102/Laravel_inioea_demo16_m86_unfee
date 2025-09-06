<?php


namespace App\Admin\Controllers;


use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CashingController extends AdminController
{
    protected function title()
    {
        return trans('admin.cashing');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $cashingdatasModel = config('admin.database.cashing_datas_model');
        $grid = new Grid(new $cashingdatasModel());

        $grid->column('id', trans('admin.cashing_id'))->sortable();
        $grid->column('user.id', trans('admin.cashing_userid'));
        $grid->column('user.nickname', trans('admin.cashing_username'));
        $grid->column('status_text', trans('admin.cashing_status'));
        $grid->column('money', trans('admin.cashing_money'));
        $grid->column('fee', trans('admin.cashing_fee'));
        $grid->column('transfer_money', trans('admin.cashing_transfer'));
        $grid->column('created_at', trans('admin.cashing_date'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->model()->orderBy('created_at', 'desc');

        return $grid;
    }

    public function form()
    {
        $cashingdatasModel = config('admin.database.cashing_datas_model');
        $form = new Form(new $cashingdatasModel());

        $form->display('id', trans('admin.cashing_id'));
        $form->display('created_datetime', trans('admin.cashing_date'));
        $form->display('user.id', trans('admin.cashing_userid'));
        $form->display('user.nickname', trans('admin.cashing_username'));
        $form->display('bank_name', trans('admin.cashing_bank_name'));
        $form->display('branch_name', trans('admin.cashing_branch_name'));
        $form->display('branch_code', trans('admin.cashing_branch_code'));
        $form->display('account_no', trans('admin.cashing_account_no'));
        $form->display('deposit_name', trans('admin.cashing_deposit_name'));

        $form->display('money', trans('admin.cashing_money'));
        $form->display('fee', trans('admin.cashing_fee'));
        $form->display('transfer_money', trans('admin.cashing_transfer'));

        $arrCashingStatus = config('constants.arrCashingStatus');

        $form->select('status', trans('admin.cashing_status'))->options($arrCashingStatus);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        return $form;
    }
}