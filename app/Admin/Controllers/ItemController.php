<?php


namespace App\Admin\Controllers;


use App\Admin\Actions\ItemDeleteAction;
use App\Admin\Actions\ItemEditAction;
use App\Models\Category;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Validator;

class ItemController extends AdminController
{
    protected function title()
    {
        return trans('admin.item');
    }

    /**
     *
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        /** @var \App\Models\Item $itemModel */
        $itemModel = config('admin.database.items_model');
        $grid = new Grid(new $itemModel());

        $grid->model()->withCount('browses');

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', trans('admin.title'));
        $grid->column('user_id', trans('admin.company_id'));
        $grid->column('company_name', trans('admin.company_name'));
        $grid->column('public_flag', trans('admin.item_status'))->display(function ($status) {
            return config('constants.arrPublicStatus')[$status];
        });
        $grid->column('created_at', trans('admin.created_at'))->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        $grid->column('browses_count', trans('admin.view_count'))->display(function ($view_count) {
            return number_format($view_count) . '回';
        })->sortable();

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->add(new ItemEditAction());
            $actions->add(new ItemDeleteAction());
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
        });

        $grid->model()->orderBy('created_at', 'desc');
        return $grid;
    }

    public function edit($id, Content $content)
    {
        $itemModel = config('admin.database.items_model');
        $item = $itemModel::findOrFail($id);

        // カテゴリーデータを読み込み
        $mainCategories = config('constants.arrItemCategory');
        $uploadImageSize = config('constants.uploadImageSize');

        $orderItems = $item->order_items()->with('user')->get();

        return $content
            ->title($item->title . ' の編集')
            ->description(' ')
            ->body(view('admin.item_edit', compact('item', 'id', 'mainCategories', 'uploadImageSize', 'orderItems')));
    }

    public function update($id)
    {
        $itemModel = config('admin.database.items_model');
        $item = $itemModel::findOrFail($id);

        $data = request()->all();
        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string'],
            'is_offering' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'website' => ['nullable', 'string', 'url'],
            'station' => ['required', 'string'],
            'address' => ['required', 'string'],
            'post_sns' => ['required', 'string'],
            'post_type' => ['required', 'string'],
            'hash_tag' => ['required', 'string'],
            'pr_account' => ['required', 'string'],
            'pr_flow' => ['required', 'string'],
            'pr_rule' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'entry_sns' => ['required', 'string'],
            'entry_follower' => ['required', 'numeric', 'min:0'],
            'gender' => ['required', 'string'],
            'entry_method' => ['required', 'string'],
        ];

        // 「その他」が選択された場合、category_otherを必須にする
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $rules['genre_other'] = ['required', 'string', 'max:100'];
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = request()->except('_token', '_method');
        
        // 「その他」が選択された場合、category_otherフィールドを保存
        if (isset($data['genre']) && $data['genre'] === 'その他') {
            $data['genre_other'] = $data['genre_other'] ?? '';
        } else {
            $data['genre_other'] = null;
        }
        
        $item->update($data);

        admin_toastr(trans('admin.update_succeeded'));

        return redirect()->route(config('admin.route.prefix') . '.admin.item.index');
    }

    public function delete($id)
    {
        $itemModel = config('admin.database.items_model');
        $item = $itemModel::findOrFail($id);
        $item->delete();

        admin_toastr(trans('admin.delete_succeeded'));

        return redirect()->route(config('admin.route.prefix') . '.admin.item.index');
    }

    public function detail($id)
    {
        $itemModel = config('admin.database.items_model');
        $item = $itemModel::findOrFail($id);

        // メインカテゴリーの配列を作成
        $arrItemCategory = config('constants.arrItemCategory');

        $show = new Show($item);
        $show->field('id', trans('admin.reviews_id'));

        $show->field('title', trans('admin.item_title'));
        $show->field('user_id', trans('admin.company_id'));
        $show->field('company_name', trans('admin.company_name'));
        $show->field('images', trans('ItemImage'))->as(function ($images) {
            return '<img src="' . asset('storage/' . $images) . '" alt="Item Image" style="width: 100px; height: 100px;">';
        })->unescape();
        $show->field('public_flag', trans('admin.item_status'))->as(function ($public_flag) {
            return config('constants.arrPublicStatus')[$public_flag];
        });
        $show->field('genre', trans('ItemCategory'))->as(function ($genre) use ($arrItemCategory) {
            return $arrItemCategory[$genre] ?? '不明';
        });
        $show->field('is_offering', trans('ItemOffering'))->as(function ($is_offering) {
            return config('constants.arrIsOffering')[$is_offering];
        });
        $show->field('price', trans('admin.item_price'));
        $show->field('description', trans('ItemDescription'));
        $show->field('website', trans('ItemURL'));
        $show->field('station', trans('ItemStation'));
        $show->field('address', trans('ItemAddress'));
        $show->field('post_sns', trans('ItemPostSNS'))->as(function ($post_sns) {
            return config('constants.arrPostSNS')[$post_sns];
        });
        $show->field('post_type', trans('ItemPostType'));
        $show->field('hash_tag', trans('ItemHashTag'));
        $show->field('pr_account', trans('ItemPRAccount'));
        $show->field('pr_flow', trans('ItemPRFlow'));
        $show->field('pr_rule', trans('ItemPRRule'));
        $show->field('condition', trans('ItemCondition'));
        $show->field('entry_sns', trans('ItemEntrySNS'));
        $show->field('entry_follower', trans('ItemEntryCount'));
        $show->field('gender', trans('Gender'))->as(function ($gender) {
            return config('constants.arrItemGender')[$gender];
        });
        $show->field('entry_method', trans('ItemEntryMethod'));
        $show->field('is_emergency', trans('ItemIsEmergency'))->as(function ($is_emergency) {
            return $is_emergency ? '急募' : '一般';
        });
        $show->field('is_recommended', trans('ItemIsRecommended'))->as(function ($is_recommended) {
            return $is_recommended ? '有効' : '無効';
        });
        $show->field('created_at', trans('admin.created_at'))->as(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });
        $show->field('updated_at', trans('admin.updated_at'))->as(function ($updated_at) {
            return date('Y-m-d H:i:s', strtotime($updated_at));
        });

        return $show;
    }
}