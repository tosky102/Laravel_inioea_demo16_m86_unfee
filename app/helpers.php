<?php

use App\Models\Category;

if (! function_exists('get_category_list')) {
    /**
     * Get category list
     *
     * @return array
     */
    function get_category_list($is_main = false)
    {
        $query = Category::query();
        if ($is_main) {
            $query->whereDoesntHave('parent');
        }
        $categories = $query->select('id', 'name')->with('sub_categories')->orderBy('id', 'asc')->get()->toArray();
        
        return $categories;
    }
}
