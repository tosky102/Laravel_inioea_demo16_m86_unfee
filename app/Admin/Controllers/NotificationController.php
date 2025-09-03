<?php


namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NotificationController extends AdminController
{
    protected function title()
    {
        return trans('admin.notifications');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $notificationsModel = config('admin.database.notifications_model');
        $grid = new Grid(new $notificationsModel());

        $grid->column('id', trans('admin.notifications_id'))->sortable();
        $grid->column('title', trans('admin.notifications_title'));
        $grid->column('comment', trans('admin.notifications_comment'));
        $grid->column('created_at', trans('admin.notifications_date'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    public function form()
    {
        $notificationsModel = config('admin.database.notifications_model');
        $form = new Form(new $notificationsModel());

        $form->display('id', 'ID');
        $form->text('title', trans('admin.notifications_title'))->rules('required|max:100');
        $form->textarea('comment', trans('admin.notifications_comment'))->rules('required');

        return $form;
    }

    public function detail($id)
    {
        $notificationsModel = config('admin.database.notifications_model');
        $notification = $notificationsModel::findOrFail($id);

        $show = new Show($notification);
        $show->field('id', trans('admin.reviews_id'));

        $show->field('title', trans('admin.notifications_title'));
        $show->field('comment', trans('admin.notifications_comment'));

        return $show;
    }
}