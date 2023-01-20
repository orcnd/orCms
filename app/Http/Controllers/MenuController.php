<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrudController;

class MenuController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new \App\Models\Menu();
        $this->route = 'admin.menu';
        $this->title = 'Menu';
    }

    public function index()
    {
        $menus = [];
        foreach ($this->model::positions() as $position => $positionName) {
            $menus[$position] = [
                'items' => $this->model::getTree($position),
                'name' => $positionName,
            ];
        }

        return view(
            'templates.' . config('app.template') . '.pages.admin.menu',
            [
                'title' => $this->title,
                'data' => $this->model->all(),
                'menus' => $menus,
                'columns' => $this->model::listableFields(),
                'tableActions' => $this->model::tableActions(),
                'routeNamePrefix' => $this->route,
                'buttons' => [
                    [
                        'href' => route($this->route . '.create'),
                        'text' => 'Create',
                    ],
                ],
            ]
        );
    }

    public function createSub($sub)
    {
        $fields = $this->model::formFields();
        foreach ($fields as $key => $field) {
            if ($field['name'] == 'parent') {
                $fields[$key]['value'] = $sub;
                $fields[$key]['type'] = 'hidden';
            }
        }
        return view($this->views . '.create', [
            'title' => $this->title,
            'form' => $fields,
            'route' => route($this->route . '.store'),
        ]);
    }
}
