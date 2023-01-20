<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class PriceController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Price();
        $this->route = 'admin.price';
        $this->title = 'Price';
    }
}
