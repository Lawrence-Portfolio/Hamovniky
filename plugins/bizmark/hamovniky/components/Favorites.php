<?php namespace Bizmark\Hamovniky\Components;

use Session;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Input;
use Bizmark\Hamovniky\Models\Offer as Offers;

class Favorites extends ComponentBase
{
    public $favoritesID;
    public function componentDetails()
    {
        return [
            'name'        => 'Favorites',
            'description' => 'Компонент работы с избранным'
        ];
    }

    public function onRun()
    {
        $this->favoritesID = Session::get('favorites');
    }

    public function onLike()
    {
        $value = Input::get('itemID');

        if (!empty($value))
        {
            if (Session::has('favorites'))
            {
                $favorites = Session::get('favorites');
                array_push($favorites, $value);
            }
            else {
                $favorites = array($value);
            }

            Session::put('favorites', $favorites);

            $count = count($favorites);
            return [
                "#headerFavorites" => $this->renderPartial('element/favorites/headerFavorites', ['count' => $count])
            ];
        }
    }

    public function onDislike()
    {
        $value = Input::get('itemID');

        if (!empty($value))
        {
            if (Session::has('favorites'))
            {
                $favorites = Session::get('favorites');
                unset($favorites[array_search($value, $favorites)]);
                Session::put('favorites', $favorites);

                $count = count($favorites);
                return [
                    "#headerFavorites" => $this->renderPartial('element/favorites/headerFavorites', ['count' => $count])
                ];
            }
        }
    }
}
