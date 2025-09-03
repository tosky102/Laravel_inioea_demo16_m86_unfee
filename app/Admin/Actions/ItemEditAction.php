<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;

class ItemEditAction extends RowAction
{
    public $name = '編集';

    public function href()
    {
        return route(config('admin.route.prefix') . '.admin.item.edit', ['id' => $this->getKey()]);
    }
}