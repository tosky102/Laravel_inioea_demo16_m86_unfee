<?php


namespace App\Admin\Controllers;

use App\Models\Item;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReviewController extends AdminController
{
    protected function title()
    {
        return trans('admin.reviews');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        /** @var \App\Models\Review $reviewsModel */
        $reviewsModel = config('admin.database.reviews_model');
        $grid = new Grid(new $reviewsModel());

        $grid->column('id', trans('admin.reviews_id'))->sortable();
        $grid->column('user.name', trans('admin.reviews_user'));
        $grid->column('toUser.name', trans('admin.reviews_to_user'));
        $grid->column('toUser.image_url', trans('admin.influencer_image'))->image('', 100, 100);
        $grid->column('comment', trans('admin.reviews_comment'))->display(function ($value) {
            return nl2br($value);
        });
        $grid->column('comment_secret', trans('admin.reviews_comment_secret'))->display(function ($value) {
            return nl2br($value);
        });
        $grid->column('rating_text', trans('admin.reviews_rating'));

        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    protected function form()
    {
        /** @var \App\Models\Review $reviewsModel */
        $reviewsModel = config('admin.database.reviews_model');
        $form = new Form(new $reviewsModel());

        $form->display('id', 'ID');
        $form->select('user_id', trans('admin.reviews_user'))->options(User::where('role', 'company')->pluck('name', 'id'))->rules('required');
        $form->select('to_user_id', trans('admin.reviews_to_user'))->options(User::where('role', 'influencer')->pluck('name', 'id'))->rules('required');
        $form->select('rating', trans('admin.reviews_rating'))->options(config('constants.arrRatingScore'))->default('3')->rules('required');
        $form->textarea('comment', trans('admin.reviews_comment'))->rules('required')->rules('required');
        $form->textarea('comment_secret', trans('admin.reviews_comment_secret'));
        $form->display('created_date', trans('admin.reviews_date'));

        return $form;
    }

    public function detail($id)
    {
        $reviewsModel = config('admin.database.reviews_model');
        $review = $reviewsModel::findOrFail($id);

        $show = new Show($review);
        
        $show->field('id', trans('admin.reviews_id'));
        $show->field('user.name', trans('admin.reviews_user'));
        $show->field('toUser.name', trans('admin.reviews_to_user'));
        $show->field('comment', trans('admin.reviews_comment'));
        $show->field('comment_secret', trans('admin.reviews_comment_secret'));
        $show->field('rating', trans('admin.reviews_rating'))->as(function ($value) {
            return config('constants.arrRatingScore')[$value];
        });
        
        $show->field('created_at', trans('admin.reviews_date'))->as(function ($value) {
            return date('Y-m-d H:i:s', strtotime($value));
        });
        // $show->panel()
        //     ->tools(function ($tools) {
        //         $tools->disableEdit();
        //     });
        return $show;
    }
}