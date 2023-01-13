<?php

namespace App\Models;

use App\Models\crudModel;
class Page extends crudModel
{
    public $timestamps = false;
    protected $fillable = ['name', 'title', 'slug', 'content', 'visibility'];

    public static function formInputs()
    {
        return ['name', 'title', 'slug', 'content', 'visibility'];
    }
    public static function listable()
    {
        return ['name', 'title', 'slug', 'content', 'visibility'];
    }

    public static function modelFields()
    {
        return [
            [
                'name' => 'name',
                'text' => 'Name',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'title',
                'text' => 'Title',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'slug',
                'text' => 'Slug',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],

            [
                'name' => 'content',
                'text' => 'Content',
                'type' => 'textarea',
                'validation' => ['required', 'string'],
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
