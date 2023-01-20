<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use App\Models\crudModel;

class Meta extends crudModel
{
    public $timestamps = false;
    protected $fillable = ['name', 'content'];

    public static function formInputs()
    {
        return ['name', 'content'];
    }
    public static function listable()
    {
        return ['name', 'content'];
    }

    /**
     * boot function of model
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        //remove cache on create
        static::created(function ($item) {
            Cache::forget('meta.' . $item->name);
        });
        //remove cache on update
        static::saved(function ($item) {
            Cache::forget('meta.' . $item->name);
        });
        //remove cache on delete
        static::deleted(function ($item) {
            Cache::forget('meta.' . $item->name);
        });
        //remove cache on update
        static::updated(function ($item) {
            Cache::forget('meta.' . $item->name);
        });
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
                'name' => 'content',
                'text' => 'Content',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
        ];
    }

    /**
     * get meta by name
     * @param string $name
     * @return string
     */
    public static function getByName($name)
    {
        if (Cache::has('meta.' . $name)) {
            return Cache::get('meta.' . $name);
        }
        $meta = self::where('name', $name)->first();
        if ($meta) {
            Cache::forever('meta.' . $name, $meta->content);
            return $meta->content;
        }
        return '';
    }
}
