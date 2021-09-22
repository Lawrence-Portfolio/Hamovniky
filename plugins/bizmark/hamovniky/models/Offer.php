<?php namespace BizMark\Hamovniky\Models;

use Model;

class Offer extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'bizmark_hamovniky_offers';

    public $rules = [
        'name',
        'slug',
        'ad_type',
        'type',
        'preview',
        'address',
        'longitude',
        'latitude',
        'repairs_type',
        'slider'
    ];

    protected $jsonable = [
        'lead_properties',
        'common_properties',
        'house_properties',
        'metro',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $attachOne = [
        'preview' => 'System\Models\File'
    ];

    public $attachMany = [
        'slider' => 'System\Models\File'
    ];

    public function getPropertyOptions()
    {
        return Property::get()->lists('name', 'name');
    }

    public function beforeSave()
    {
        if ($this->flat_type == '') {
            $this->flat_type = null;
        }
        if ($this->house_type == '') {
            $this->house_type = null;
        }
        if ($this->commercial_type == '') {
            $this->commercial_type = null;
        }
        if ($this->repairs_type == '') {
            $this->repairs_type = null;
        }
        if ($this->bath_type == '') {
            $this->bath_type = null;
        }
    }
}
