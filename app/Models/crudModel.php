<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crudModel extends Model
{
    use HasFactory;

    /**
     * variables that can be filled on create and edit page
     * @return array
     */
    public static function formInputs()
    {
        return [];
    }

    /**
     *  action list for index table
     * @return array<array>
     */
    public static function tableActions()
    {
        return [
            [
                'permission' => 'view',
                'route' => 'show',
                'text' => 'View',
            ],
            [
                'permission' => 'update',
                'route' => 'edit',
                'text' => 'Edit',
            ],
            [
                'permission' => 'delete',
                'route' => 'destroy',
                'text' => 'Delete',
            ],
        ];
    }

    /**
     * list of variables that can be listed on index page
     * @return array
     */
    public static function listable()
    {
        return [];
    }

    /**
     * Generate listable fields array from modal fields
     * @return array<array>
     */
    public static function listableFields()
    {
        $fields = static::modelFields();
        $listableFields = [];
        foreach ($fields as $field) {
            if (in_array($field['name'], static::listable())) {
                $temp = [
                    'name' => $field['name'],
                    'text' => $field['text'],
                    'type' => $field['type'],
                ];
                if (isset($field['options'])) {
                    $temp['options'] = $field['options'];
                }
                $listableFields[] = $temp;
            }
        }
        return $listableFields;
    }

    /**
     * Generate form field array from modal fields
     * @param array|null $data
     * @return array<array>
     */
    public static function formFields($data = null)
    {
        $fields = static::modelFields();
        $formFields = [];
        foreach ($fields as $field) {
            if (in_array($field['name'], static::formInputs())) {
                $formFields[] = [
                    'name' => $field['name'],
                    'text' => $field['text'],
                    'type' => $field['type'],
                    'value' => $data ? $data[$field['name']] : '',
                    'options' => isset($field['options'])
                        ? $field['options']
                        : [],
                    'required' => in_array('required', $field['validation'])
                        ? 'required'
                        : '',
                ];
            }
        }
        return $formFields;
    }

    /**
     * Generate validation rules from modal fields
     * @return array<array>
     */
    public static function validationRules()
    {
        $rules = [];
        foreach (self::modelFields() as $field) {
            $rules[$field['name']] = implode('|', $field['validation']);
        }
        return $rules;
    }

    /**
     * fields of the model, defines the fields of the model
     * @return array<array>
     */
    public static function modelFields()
    {
        return [];
    }
}
