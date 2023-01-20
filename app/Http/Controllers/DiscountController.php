<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class DiscountController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Discount();
        $this->route = 'admin.discount';
        $this->title = 'Discount';
    }
}
