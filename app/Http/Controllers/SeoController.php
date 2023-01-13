<?php

namespace App\Http\Controllers;

class SeoController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Seo();
        $this->route = 'admin.seo';
        $this->title = 'Seo';
    }
}
