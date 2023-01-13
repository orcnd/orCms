<?php

namespace App\Models;
use App\Models\crudModel;
class Product extends crudModel
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'buyUrl',
        'visibility',
        'order',
    ];

    public static function formInputs()
    {
        return [
            'name',
            'description',
            'category_id',
            'buyUrl',
            'visibility',
            'order',
        ];
    }
    public static function listable()
    {
        return [
            'name',
            'description',
            'category_id',
            'buyUrl',
            'visibility',
            'order',
        ];
    }

    public static function modelFields()
    {
        $categories = \App\Models\Category::all();
        $categoriesForm = [];
        foreach ($categories as $category) {
            $categoriesForm[$category->id] = $category->name;
        }
        return [
            [
                'name' => 'name',
                'text' => 'Name',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'description',
                'text' => 'Description',
                'type' => 'textarea',
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'category_id',
                'text' => 'Category',
                'type' => 'select',
                'options' => $categoriesForm,
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'buyUrl',
                'text' => 'Buy URL',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'order',
                'text' => 'Order',
                'type' => 'text',
                'validation' => [],
            ],
            [
                'name' => 'visibility',
                'text' => 'Visibility',
                'type' => 'select',
                'options' => ['public' => 'Public', 'private' => 'Private'],
                'validation' => ['required', 'string'],
            ],
        ];
    }
}
