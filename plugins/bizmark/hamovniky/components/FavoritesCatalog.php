<?php namespace Bizmark\Hamovniky\Components;

use Session;
use Cms\Classes\ComponentBase;
use BizMark\Hamovniky\Models\Offer as Offers;

class FavoritesCatalog extends ComponentBase
{
    public $offers;
    public function componentDetails()
    {
        return [
            'name'        => 'Favorites Catalog',
            'description' => 'Вывод всего избранного'
        ];
    }

    public function onRun()
    {
        $data = Session::get('favorites');
        if (!empty($data)) {
            $this->offers = Offers::whereIn('id', $data)->get();
        }

    }
}
