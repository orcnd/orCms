<?php

namespace App\Models;
use App\Models\crudModel;
use Illuminate\Support\Facades\Cache;

class Advert extends crudModel
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'title',
        'text',
        'type',
        'url',
        'end_date',
        'status',
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
            Cache::forget('advert' . $item->type);
        });
        //remove cache on update
        static::saved(function ($item) {
            Cache::forget('advert' . $item->type);
        });
        //remove cache on delete
        static::deleted(function ($item) {
            Cache::forget('advert' . $item->type);
        });
        //remove cache on update
        static::updated(function ($item) {
            Cache::forget('advert' . $item->type);
        });
    }

    public static function formInputs()
    {
        return ['name', 'title', 'text', 'type', 'url', 'end_date', 'status'];
    }
    public static function listable()
    {
        return ['name', 'title', 'text', 'type', 'url', 'end_date', 'status'];
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
                'name' => 'text',
                'text' => 'Text',
                'type' => 'textarea',
                'validation' => ['required', 'string', 'min:4', 'max:255'],
            ],
            [
                'name' => 'url',
                'text' => 'Url',
                'type' => 'text',
                'validation' => ['required', 'string', 'min:8', 'max:255'],
            ],
            [
                'name' => 'type',
                'text' => 'Type',
                'type' => 'select',
                'options' => [
                    'overLogo' => 'Over Logo',
                    'pageTop' => 'Page Top',
                    'pageBottom' => 'Page Bottom',
                ],
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'end_date',
                'type' => 'dateTime',
                'text' => 'End Date',
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'status',
                'text' => 'status',
                'type' => 'select',
                'options' => ['enabled' => 'Enabled', 'disabled' => 'Disabled'],
                'validation' => ['required', 'string'],
            ],
        ];
    }

    /**
     * get advert by type
     * @param string $type
     * @return mixed
     */
    public static function getByType($type)
    {
        if (Cache::has('advert' . $type)) {
            return Cache::get('advert' . $type);
        }
        $advert = self::where('type', $type)
            ->where('status', 'enabled')
            ->where('end_date', '>', date('Y-m-d H:i:s'))
            ->first();
        Cache::put('advert' . $type, $advert, 60 * 30);
        return $advert;
    }
}
