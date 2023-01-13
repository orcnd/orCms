<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
