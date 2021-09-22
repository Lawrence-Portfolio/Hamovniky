<?php namespace BizMark\Hamovniky\Models;

use Model;

class Property extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'bizmark_hamovniky_properties';


    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
