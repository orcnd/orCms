<?php

namespace App\Http\Controllers;
class ProductController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Product();
        $this->route = 'admin.product';
        $this->title = 'Product';
    }
}
