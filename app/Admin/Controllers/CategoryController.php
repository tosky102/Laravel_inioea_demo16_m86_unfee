<?php


namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    protected function title()
    {
        return trans('admin.category');
    }

    protected function grid()
    {
        /** @var \App\Models\Category $categoryModel */
        $categoryModel = config('admin.database.categories_model');
        $grid = new Grid(new $categoryModel());

        $grid->column('id', 'ID');
        // $grid->column('parent_id', trans('admin.category_parent'))->display(function ($parent_id) {
        //     $parent = Category::find($parent_id);
        //     return $parent ? $parent->name : '-';
        // });
        $grid->column('name', trans('admin.category_name'));
        $grid->model()->orderBy('id', 'asc');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    protected function form()
    {
        $categoryModel = config('admin.database.categories_model');
        $form = new Form(new $categoryModel());

        $form->display('id', 'ID');
        // $form->select('parent_id', trans('admin.category_parent'))->options(Category::whereNull('parent_id')->pluck('name', 'id'));
        $form->text('name', trans('admin.category_name'))->rules('required|max:100');

        return $form;
    }

    protected function detail($id)
    {
        $categoryModel = config('admin.database.categories_model');

        $category = $categoryModel::findOrFail($id);
        $show = new Show($category);

        $show->field('id', 'ID');
        $show->field('name', trans('admin.category_name'));

        return $show;
    }
}