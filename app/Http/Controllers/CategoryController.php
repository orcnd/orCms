<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class CategoryController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Category();
        $this->route = 'admin.category';
        $this->title = 'Category';
    }
}
