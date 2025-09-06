<?php


namespace App\Admin\Controllers;


use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HtmlpartController extends AdminController
{
    protected function title()
    {
        return trans('admin.htmlpart');
    }

    protected function grid()
    {
        /** @var \App\Models\HtmlPart $htmlpartModel */
        $htmlpartModel = config('admin.database.html_parts_model');
        $grid = new Grid(new $htmlpartModel());

        $grid->column('id', 'ID');
        $grid->column('name', trans('admin.htmlpart_name'));
        $grid->column('title', trans('admin.htmlpart_title'));
        $grid->model()->orderBy('created_at', 'desc');

        $grid->disableCreateButton();
        return $grid;
    }

    protected function form()
    {
        $htmlpartModel = config('admin.database.html_parts_model');
        $form = new Form(new $htmlpartModel());

        $form->display('id', 'ID');
        $form->display('title', trans('admin.htmlpart_title'))->rules('required|max:100');
        $form->text('name', trans('admin.htmlpart_name'))->rules('required|max:100');
        $form->textarea('desc', trans('admin.htmlpart_desc'))->rules('required');

        return $form;
    }

    protected function detail($id)
    {
        $htmlpartModel = config('admin.database.html_parts_model');

        $htmlpart = $htmlpartModel::findOrFail($id);
        $show = new Show($htmlpart);

        $show->field('id', 'ID');
        $show->field('title', trans('admin.htmlpart_title'));
        $show->field('desc', trans('admin.htmlpart_desc'));

        return $show;
    }
}