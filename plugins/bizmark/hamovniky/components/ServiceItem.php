<?php namespace Bizmark\Hamovniky\Components;

use Cms\Classes\ComponentBase;
use BizMark\Hamovniky\Models\Service as Services;

class ServiceItem extends ComponentBase
{
    public $service;

    public function componentDetails()
    {
        return [
            'name'        => 'Service Item',
            'description' => 'Вывод карточки услуги'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Ссылка предмета',
                'default'     => '{{ :item }}',
            ]
        ];
    }

    public function onRun()
    {
        $this->service = Services::where('slug', $this->property('slug'))->first();

        if (empty($this->service)) {
            return $this->controller->run('404');
        }
    }
}
