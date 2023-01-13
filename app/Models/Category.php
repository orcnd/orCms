<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends crudModel
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public static function formInputs()
    {
        return ['name'];
    }
    public static function listable()
    {
        return ['name'];
    }

    public static function modelFields()
    {
        return [
            [
                'name' => 'name',
                'text' => 'Name',
                'type' => 'text',
                'required' => 'required',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
        ];
    }
}
