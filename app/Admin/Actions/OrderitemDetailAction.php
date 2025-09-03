<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;

class OrderitemDetailAction extends RowAction
{
    public $name = '表示';

    public function href()
    {
        return route(config('admin.route.prefix') . '.admin.orderitem.detail', ['id' => $this->getKey()]);
    }
}