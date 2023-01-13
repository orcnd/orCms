<?php

namespace App\Http\Controllers;
class GalleryController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Gallery();
        $this->route = 'admin.gallery';
        $this->title = 'Gallery';
    }
}
