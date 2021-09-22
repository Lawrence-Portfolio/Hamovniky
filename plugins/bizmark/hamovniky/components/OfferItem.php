<?php namespace Bizmark\Hamovniky\Components;

use Cms\Classes\ComponentBase;
use BizMark\Hamovniky\Models\Offer as Offers;

class OfferItem extends ComponentBase
{
    public $offer;
    public $offers;

    public function componentDetails()
    {
        return [
            'name'        => 'Offer Item',
            'description' => 'Вывод карточки объявления'
        ];
    }

    public function defineProperties()
    {
        return [
            'type' => [
                'title'       => 'Тип объекта',
                'default'     => '{{ :type }}',
            ],
            'slug' => [
                'title'       => 'Ссылка объекта',
                'default'     => '{{ :item }}',
            ]
        ];
    }

    public function onRun()
    {
        $this->offer = Offers::where('slug', $this->property('slug'))->first();

        if (empty($this->offer)) {
            return $this->controller->run('404');
        }

        $this->offers = Offers::where('slug', '<>', $this->property('slug'))
            ->where('is_published', true)
            ->where('type', $this->offer->type)
            ->where('ad_type', $this->offer->ad_type)
            ->get();
    }
}
