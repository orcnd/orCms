<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class MetaController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Meta();
        $this->route = 'admin.meta';
        $this->title = 'Meta';
    }
}
