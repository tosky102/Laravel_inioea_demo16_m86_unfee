<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;

class ItemDeleteAction extends RowAction
{
    public $name = '削除';

    public function href()
    {
        return route(config('admin.route.prefix') . '.admin.item.delete', ['id' => $this->getKey()]);
    }
}