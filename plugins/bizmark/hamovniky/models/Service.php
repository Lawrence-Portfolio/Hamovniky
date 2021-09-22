<?php namespace BizMark\Hamovniky\Models;

use Model;

/**
 * Service Model
 */
class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'bizmark_hamovniky_services';

    public $rules = [
        'name' => 'required',
        'slug' => 'required'
    ];

    protected $jsonable = [
        'description'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public $attachOne = [
        'image' => 'System\Models\File',
        'preview' => 'System\Models\File',
    ];
}
