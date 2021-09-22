<?php namespace Bizmark\Hamovniky\Components;

use Cms\Classes\ComponentBase;
use BizMark\Hamovniky\Models\Service as Services;

class ServiceCatalog extends ComponentBase
{
    public $services;

    public function componentDetails()
    {
        return [
            'name'        => 'Service Catalog',
            'description' => 'Вывод списка услуг'
        ];
    }

    public function onRun()
    {
        $this->services = Services::All();
    }
}
