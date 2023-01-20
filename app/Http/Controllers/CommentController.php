<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CrudController;

class CommentController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Comment();
        $this->route = 'admin.comment';
        $this->title = 'Comment';
    }
}
