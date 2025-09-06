<?php


namespace App\Admin\Controllers;


use App\Models\User;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class OrderpointController extends AdminController
{
    protected function title()
    {
        return trans('admin.orderpoint');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $orerpointModel = config('admin.database.order_points_model');
        $grid = new Grid(new $orerpointModel());

        $grid->column('user.id', trans('admin.orderpoint_userid'));
        $grid->column('user.nickname', trans('admin.orderpoint_username'));
        $grid->column('status_text', trans('admin.orderpoint_status'));
        $grid->column('payment_text', trans('admin.orderpoint_payment'));
        $grid->column('point', trans('admin.orderpoint_point'));
        $grid->column('created_at', trans('admin.orderpoint_date'))->display(function ($created_at) {
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
        $orerpointModel = config('admin.database.order_points_model');
        $form = new Form(new $orerpointModel());

        $form->hidden('payment');
        $form->hidden('user_id');
        $form->hidden('point');

        $form->display('created_at_date', trans('admin.orderpoint_date'));

        $form->display('user.id', trans('admin.orderpoint_userid'))->rules('required');
        $form->display('user.nickname', trans('admin.orderpoint_username'))->rules('required');
        $form->display('payment_text', trans('admin.orderpoint_payment'))->rules('required');
        $form->display('point', trans('admin.orderpoint_point'))->rules('required');

        $arrPaymentStatus = config('constants.arrPaymentStatus');

        $form->select('status', trans('admin.orderpoint_status'))->options($arrPaymentStatus);

        $script = <<<SCRIPT

$(document).ready(function(){
var val = $('input[name="payment"]').val();
var status = $('select[name="status"]').children("option:selected").val();
if (val == 'bank_transfer' && status != 1) {
$('select[name="status"]').prop("disabled", false);
} else {
$('select[name="status"]').prop("disabled", true);
}
});

SCRIPT;
        Admin::script($script);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        $form->saving(function (Form $form) {
            if ($form->payment == 'bank_transfer' && $form->status == 1) {
                $user_id = $form->user_id;
                if ($user_id) {
                    $user = User::find($form->user_id);
                    $user->point = $user->point + $form->point;
                    $user->save();
                }
            }
        });

        return $form;
    }
}