<?php


namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ConfigController extends AdminController
{
    protected function title()
    {
        return trans('admin.config');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        /** @var \App\Models\Config $configModel */
        $configModel = config('admin.database.configs_model');
        $grid = new Grid(new $configModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('code', trans('admin.config_code'));
        $grid->column('name', trans('admin.config_name'));
        $grid->column('unit_name', trans('admin.config_unit_name'));
        $grid->column('type', trans('admin.config_type'));
        $grid->column('number', trans('admin.config_number'));

        $grid->column('created_at', trans('admin.created_at'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });

        $grid->model()->orderBy('created_at', 'desc');

        $grid->disableCreateButton();

        return $grid;
    }

    public function form()
    {
        $configModel = config('admin.database.configs_model');
        $form = new Form(new $configModel());

        $form->display('id', 'ID');
        $form->display('code', trans('admin.config_code'))->rules('required|max:100');
        $form->display('name', trans('admin.config_name'))->rules('required|max:100');
        $form->display('unit_name', trans('admin.config_unit_name'))->rules('required|max:100');
        $form->display('type', trans('admin.config_type'))->rules('required|max:100');
        $form->number('number', trans('admin.config_number'))->rules('required');

        return $form;
    }

    public function detail($id)
    {
        $configModel = config('admin.database.configs_model');
        $config = $configModel::findOrFail($id);

        $show = new Show($config);
        $show->field('id', 'ID');
        $show->field('code', trans('admin.config_code'));
        $show->field('name', trans('admin.config_name'));
        $show->field('unit_name', trans('admin.config_unit_name'));
        $show->field('type', trans('admin.config_type'));
        $show->field('number', trans('admin.config_number'));

        return $show;
    }
}