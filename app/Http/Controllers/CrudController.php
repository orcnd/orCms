<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
class CrudController extends BaseController
{
    /**
     * model of the controller
     * @var mixed
     */
    protected $model;

    /**
     * route name of the controller
     * @var mixed
     */
    protected $route;

    /**
     * views name of the controller
     * @var mixed
     */
    protected $views = 'crud';

    /**
     * title of the pages
     * @var mixed
     */
    protected $title;

    public function __construct()
    {
        $this->views = 'templates.' . config('app.template') . '.crud';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view($this->views . '.index', [
            'title' => $this->title,
            'data' => $this->model->all(),
            'columns' => $this->model::listableFields(),
            'tableActions' => $this->model::tableActions(),
            'routeNamePrefix' => $this->route,
            'buttons' => [
                [
                    'href' => route($this->route . '.create'),
                    'text' => 'Create',
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return object
     */
    public function create()
    {
        return view($this->views . '.create', [
            'title' => $this->title,
            'form' => $this->model::formFields(),
            'route' => route($this->route . '.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $request->validate($this->model::validationRules());
        $data = $request->all();
        foreach ($this->model::formFields() as $field) {
            if ($field['type'] == 'date' || $field['type'] == 'dateTime') {
                $data[$field['name']] = date(
                    'Y-m-d H:i:s',
                    strtotime($data[$field['name']])
                );
            }
        }
        $this->model->create($data);
        return redirect()->route($this->route . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  object $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $item = $this->model::findOrFail($item);
        dd($item->toArray());
        return '';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Database\Eloquent\Model $item
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        $item = $this->model::findOrFail($item);
        return view($this->views . '.edit', [
            'title' => 'edit ' . $this->title . '(' . $item->name . ')',
            'route' => route($this->route . '.update', $item),
            'form' => $this->model::formFields($item->toArray()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Database\Eloquent\Model  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        $item = $this->model::findOrFail($item);
        $request->validate($this->model::validationRules());
        $data = $request->all();
        foreach ($this->model::formFields() as $field) {
            if ($field['type'] == 'date' || $field['type'] == 'dateTime') {
                $data[$field['name']] = date(
                    'Y-m-d H:i:s',
                    strtotime($data[$field['name']])
                );
            }
        }

        $item->update($data);
        return redirect()->route($this->route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param object  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item)
    {
        $item = $this->model::findOrFail($item);
        $item->delete();
        return redirect()->route($this->route . '.index');
    }
}
