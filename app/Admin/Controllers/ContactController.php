<?php


namespace App\Admin\Controllers;


use App\Models\AdminConfirm;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ContactController extends AdminController
{
    protected function title()
    {
        return trans('admin.contacts');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $uri = 'contact';
        AdminConfirm::updateOrCreate(['uri' => $uri], ['confirmed_at' => now()]);

        /** @var \App\Models\Contact $contactsModel */
        $contactsModel = config('admin.database.contacts_model');
        $grid = new Grid(new $contactsModel());

        $grid->column('id', 'ID');
        $grid->column('user.id', trans('admin.contacts_user_id'));
        $grid->column('user.contact_name', trans('admin.contacts_user'));
        $grid->column('title', trans('admin.contacts_title'));
        $grid->column('created_at', trans('admin.contacts_date'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });


        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });
        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    public function detail($id)
    {
        $contactsModel = config('admin.database.contacts_model');
        $contact = $contactsModel::findOrFail($id);

        $show = new Show($contact);

        $show->field('id', 'ID');
        $show->field('user.id', trans('admin.contacts_user_id'));
        $show->field('user_nickname', trans('admin.contacts_user'));
        $show->field('title', trans('admin.contacts_title'));
        $show->field('content', trans('admin.contacts_content'));
        $show->field('created_at', trans('admin.contacts_date'));

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
            });
        return $show;
    }
}