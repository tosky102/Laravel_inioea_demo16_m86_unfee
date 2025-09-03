<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;

class OrderitemDeleteAction extends RowAction
{
    public $name = '削除';

    public function href()
    {
        return route(config('admin.route.prefix') . '.admin.orderitem.delete', ['id' => $this->getKey()]);
    }
}