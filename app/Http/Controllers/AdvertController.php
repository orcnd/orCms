<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class AdvertController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Advert();
        $this->route = 'admin.advert';
        $this->title = 'Advert';
    }
}
