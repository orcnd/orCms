<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class PageController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Page();
        $this->route = 'admin.page';
        $this->title = 'Page';
    }
}
