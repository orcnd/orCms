<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use App\Models\crudModel;

class Seo extends crudModel
{
    public $timestamps = false;

    protected $fillable = [
        'route',
        'page_id',
        'title',
        'description',
        'keywords',
    ];

    /**
     * boot function of model
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        //remove cache on create
        static::created(function ($item) {
            Cache::forget('seo');
        });
        //remove cache on update
        static::saved(function ($item) {
            Cache::forget('seo');
        });
        //remove cache on delete
        static::deleted(function ($item) {
            Cache::forget('seo');
        });
        //remove cache on update
        static::updated(function ($item) {
            Cache::forget('seo');
        });
    }

    public static function formInputs()
    {
        return ['route', 'page_id', 'title', 'description', 'keywords'];
    }
    public static function listable()
    {
        return ['route', 'page_id', 'title', 'description', 'keywords'];
    }

    public static function modelFields()
    {
        return [
            [
                'name' => 'route',
                'text' => 'route',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'page_id',
                'text' => 'page id',
                'type' => 'text',
                'validation' => [],
            ],
            [
                'name' => 'title',
                'text' => 'Title',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],

            [
                'name' => 'description',
                'text' => 'description',
                'type' => 'textarea',
                'validation' => ['required', 'string'],
            ],

            [
                'name' => 'keywords',
                'text' => 'Keywords',
                'type' => 'text',
                'validation' => ['required', 'string'],
            ],
        ];
    }

    /**
     * get seo data for route
     * @param string $route
     * @param integer|null $page_id
     * @return array
     */
    public static function getRoute($route, $page_id = null)
    {
        if (Cache::has('seo')) {
            $seo = Cache::get('seo');
        } else {
            $seoData = self::all();
            $seo = [];
            foreach ($seoData as $item) {
                $data = [
                    'title' => $item->title,
                    'description' => $item->description,
                    'keywords' => $item->keywords,
                ];

                if ($item->page_id) {
                    $seo[$item->route . '.page_id=' . $item->page_id] = $item;
                } else {
                    $seo[$item->route] = $data;
                }
            }
            Cache::forever('seo', $seo);
        }
        if (isset($page_id)) {
            if (isset($seo[$route . '.page_id=' . $page_id])) {
                return $seo[$route . '.page_id=' . $page_id];
            } else {
                return [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ];
            }
        } else {
            if (isset($seo[$route])) {
                return $seo[$route];
            } else {
                return [
                    'title' => '',
                    'description' => '',
                    'keywords' => '',
                ];
            }
        }
    }
}
