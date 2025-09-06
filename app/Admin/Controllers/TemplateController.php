<?php


namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TemplateController extends AdminController
{
    protected function title()
    {
        return trans('admin.template');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        /** @var \App\Models\MessageTemplate $templateModel */
        $templateModel = config('admin.database.message_templates_model');
        $grid = new Grid(new $templateModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('type', trans('admin.template_type'))->display(function ($type) {
            return config('constants.arrMessageTemplate')[$type];
        });
        $grid->column('template', trans('admin.template_content'))->display(function ($value) {
            return nl2br(e($value));
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
        /** @var \App\Models\MessageTemplate $templateModel */
        $templateModel = config('admin.database.message_templates_model');
        $form = new Form(new $templateModel);

        $form->display('id', 'ID');
        $form->select('type', trans('admin.template_type'))->options(config('constants.arrMessageTemplate'))->rules('required');
        $form->textarea('template', trans('admin.template_content'))->rules('required');

        return $form;
    }

    public function detail($id)
    {
        /** @var \App\Models\MessageTemplate $templateModel */
        $templateModel = config('admin.database.message_templates_model');
        $template = $templateModel::findOrFail($id);

        $show = new Show($template);
        $show->field('id', 'ID');

        $show->field('type', trans('admin.template_type'))->as(function ($type) {
            return config('constants.arrMessageTemplate')[$type];
        });
        $show->field('template', trans('admin.template_content'))->as(function ($value) {
            return nl2br(e($value));
        })->unescape();
        
        return $show;
    }
}
