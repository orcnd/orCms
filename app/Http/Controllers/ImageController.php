<?php

namespace App\Http\Controllers;

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
