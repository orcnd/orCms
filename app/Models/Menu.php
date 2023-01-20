<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use App\Models\crudModel;
class Menu extends crudModel
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'title',
        'description',
        'badge',
        'target',
        'type',
        'visibility',
        'position',
        'parent',
        'order',
        'icon',
    ];

    public static function formInputs()
    {
        return [
            'name',
            'title',
            'description',
            'badge',
            'target',
            'type',
            'visibility',
            'position',
            'parent',
            'order',
            'icon',
        ];
    }
    public static function listable()
    {
        return [
            'id',
            'name',
            'title',
            'description',
            'badge',
            'target',
            'type',
            'visibility',
            'position',
            'parent',
            'order',
            'icon',
        ];
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
            Cache::forget('menuTree' . $item->position);
        });
        //remove cache on update
        static::saved(function ($item) {
            Cache::forget('menuTree' . $item->position);
        });
        //remove cache on delete
        static::deleted(function ($item) {
            Cache::forget('menuTree' . $item->position);
        });
        //remove cache on update
        static::updated(function ($item) {
            Cache::forget('menuTree' . $item->position);
        });
    }

    /**
     * Menu Positions
     * @return array<array>
     */

    public static function positions()
    {
        return [
            'topMain' => 'Top Main Menu',
            'sideMainTop' => 'Side Menu Top',
            'sideMainBottom' => 'Side Menu Bottom',
            'footer' => 'Footer',
        ];
    }

    public static function modelFields()
    {
        return [
            [
                'name' => 'id',
                'text' => 'ID',
                'type' => 'text',
                'validation' => [],
            ],
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
                'validation' => ['required', 'string', 'max:255'],
            ],
            [
                'name' => 'description',
                'text' => 'Description',
                'type' => 'textarea',
                'validation' => ['string', 'max:255'],
            ],
            [
                'name' => 'badge',
                'text' => 'Badge',
                'type' => 'text',
                'validation' => ['string', 'max:255'],
            ],
            [
                'name' => 'target',
                'text' => 'Target',
                'type' => 'text',
                'validation' => ['required', 'max:255'],
            ],
            [
                'name' => 'type',
                'text' => 'Type',
                'type' => 'select',
                'options' => [
                    'url' => 'Url',
                    'staticRoute' => 'Static Page',
                    'dynamicPage' => 'Dynamic Page',
                ],
                'validation' => ['required'],
            ],
            [
                'name' => 'visibility',
                'text' => 'Visibility',
                'type' => 'select',
                'options' => ['visible' => 'Visible', 'hidden' => 'Hidden'],
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'position',
                'text' => 'position',
                'type' => 'select',
                'options' => self::positions(),
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'parent',
                'text' => 'Parent',
                'type' => 'text',
                'validation' => ['min:4', 'max:255'],
            ],
            [
                'name' => 'order',
                'text' => 'Order',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'icon',
                'text' => 'Icon',
                'type' => 'text',
                'validation' => ['string', 'min:4', 'max:255'],
            ],
        ];
    }

    /**
     * menu tree for menu builder
     * @param string $position
     * @return \Illuminate\Contracts\Cache\Repository|array<object>
     */
    public static function getTree($position)
    {
        if (Cache::has('menuTree' . $position)) {
            return Cache::get('menuTree' . $position);
        }
        $menu = self::where('position', $position)
            ->where('parent', 0)
            ->orderBy('order')
            ->get();
        $menuTree = [];
        foreach ($menu as $item) {
            $tempObject = (object) $item->toArray();
            $tempObject->target = $item->getRouteAttribute();
            $tempObject->subElements = [];
            $menuTree[$item->id] = $tempObject;
        }

        foreach (
            self::where('parent', '!=', 0)
                ->orderBy('order')
                ->get()
            as $subItem
        ) {
            if (isset($menuTree[$subItem->parent])) {
                $tempObject = (object) $subItem->toArray();
                $tempObject->target = $subItem->getRouteAttribute();
                $menuTree[$subItem->parent]->subElements[] = $tempObject;
            }
        }
        Cache::forever('menuTree' . $position, $menuTree);
        return $menuTree;
    }

    function getRouteAttribute()
    {
        if ($this->type == 'staticRoute') {
            return route($this->target);
        } elseif ($this->type == 'dynamicPage') {
            return route('page', ['slug' => $this->target]);
        } else {
            return $this->target;
        }
    }
}
