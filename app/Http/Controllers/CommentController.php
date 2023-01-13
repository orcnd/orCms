<?php

namespace App\Http\Controllers;

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
