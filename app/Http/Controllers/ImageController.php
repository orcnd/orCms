<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class ImageController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Image();
        $this->route = 'admin.image';
        $this->title = 'Image';
    }
}
