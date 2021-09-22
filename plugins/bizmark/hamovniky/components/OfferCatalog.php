<?php namespace Bizmark\Hamovniky\Components;

use Cms\Classes\ComponentBase;
use BizMark\Hamovniky\Models\Offer as Offers;
use Illuminate\Support\Facades\Input;
use October\Rain\Exception\AjaxException;
use Session;

class OfferCatalog extends ComponentBase
{
    public $offers;

    public function componentDetails()
    {
        return [
            'name'        => 'Offer Catalog',
            'description' => 'Вывод списка объявлений'
        ];
    }
    public function defineProperties()
    {
        return [
            'mode' => [
                'title'       => 'Режим вывода листинга',
                'type'        => 'dropdown',
                'default'     => 'All',
                'options'     => [
                    'All'               =>  'Все объявления',
                    'Urban-Sale'        =>  '[Продажа] Квартиры и комнаты',
                    'Suburban-Sale'     =>  '[Продажа] Загородная недвижимость',
                    'Commercial-Sale'   =>  '[Продажа] Коммерческая недвижимость',
                    'Urban-Rent'        =>  '[Аренда] Квартиры и комнаты',
                    'Suburban-Rent'     =>  '[Аренда] Загородная недвижимость',
                    'Commercial-Rent'   =>  '[Аренда] Коммерческая недвижимость',
                ]
            ],
            'items' => [
                'title'       => 'Количество',
                'description' => 'Определяет количество предметов на одной странице',
                'default'     => '9',
            ],
        ];
    }

    public function onRun()
    {
        switch ($this->properties['mode']) {
            case 'All':
                $this->page['offers_count'] = Offers::where('is_published', true)->count();
                $this->offers = Offers::where('is_published', true)->paginate($this->property('items'));
                break;
            case 'Urban-Sale':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'APARTMENT')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'APARTMENT')
                    ->paginate($this->property('items'));
                break;
            case 'Suburban-Sale':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'ESTATE')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'ESTATE')
                    ->paginate($this->property('items'));
                break;
            case 'Commercial-Sale':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'COMMERCIAL')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'SALE')
                    ->where('type', 'COMMERCIAL')
                    ->paginate($this->property('items'));
                break;
            case 'Urban-Rent':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'APARTMENT')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'APARTMENT')
                    ->paginate($this->property('items'));
                break;
            case 'Suburban-Rent':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'ESTATE')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'ESTATE')
                    ->paginate($this->property('items'));
                break;
            case 'Commercial-Rent':
                $this->page['offers_count'] = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'COMMERCIAL')
                    ->count();
                $this->offers = Offers::where('is_published', true)
                    ->where('ad_type', 'RENT')
                    ->where('type', 'COMMERCIAL')
                    ->paginate($this->property('items'));
                break;
        }

        $this->page['offers'] = $this->offers;
    }

    public function onFilter()
    {
        $data = Input::all();

        // Types:
        $adType = e(array_get($data, 'ad-type'));
        $sortType = e(array_get($data, 'sort-type'));
        $roomNumbers = e(array_get($data, 'numberRooms'));
        $objectType = e(array_get($data, 'object-type'));
        $propertyType = e(array_get($data, 'property-type'));
        $repairType = e(array_get($data, 'repair-type'));
        $bathType = e(array_get($data, 'bath-type'));

        // Range values:
        $minPrice = e(array_get($data, 'min-price'));
        $maxPrice = e(array_get($data, 'max-price'));
        $minArea = e(array_get($data, 'min-area'));
        $maxArea = e(array_get($data, 'max-area'));
        $minFloor = e(array_get($data, 'min-floor'));
        $maxFloor = e(array_get($data, 'max-floor'));

        // Flags:
        $furnitureFlag = e(array_get($data, 'furniture'));
        $parkingFlag = e(array_get($data, 'parking'));
        $petsFlag = e(array_get($data, 'pets'));
        $childrenFlag = e(array_get($data, 'children'));
        $elevatorFlag = e(array_get($data, 'elevator'));
        $basementFlag = e(array_get($data, 'basement'));
        $penthouseFlag = e(array_get($data, 'penthouse'));

        $filter = (new Offers);

        // Filtering:
        if (!empty($adType)) {
            $filter = $filter->where('ad_type', $adType);
        }
        if (!empty($objectType)) {
            $filter = $filter->where('type', $objectType);
        }
        if (!empty($roomNumbers)) {
            $string = explode('|', $roomNumbers);
            $flag = str_contains($roomNumbers, '4');

            if ($flag) {
                for ($i = 0, $k = 5; $i < 95; $i++, $k++) {
                    array_push($string, $k);
                }
            }
            $filter = $filter->whereIn('rooms', $string);

        }
        if (!empty($propertyType)) {
            if ($objectType == 'APARTMENT') {
                $filter = $filter->where('flat_type', $propertyType);
            }
            elseif ($objectType == 'ESTATE') {
                $filter = $filter->where('house_type', $propertyType);
            }
            elseif ($objectType == 'COMMERCIAL') {
                $filter = $filter->where('commercial_type', $propertyType);
            }
        }
        if (!empty($repairType)) {
            $filter = $filter->where('repairs_type', $repairType);
        }
        if (!empty($bathType)) {
            $filter = $filter->where('bath_type', $bathType);
        }
        if (!empty($minPrice) || !empty($maxPrice)) {
            if (!empty($minPrice)) {
                $filter = $filter->where('price', '>=', $minPrice);
            }
            elseif (!empty($maxPrice)) {
                $filter = $filter->where('price', '<=', $maxPrice);
            }
            else {
                $filter = $filter->where('price', '>=', $minPrice)->where('price', '<=', $maxPrice);
            }
        }
        if (!empty($minArea) || !empty($maxArea)) {
            if (!empty($minArea)) {
                $filter = $filter->where('area_size', '>=', $minArea);
            }
            elseif (!empty($maxArea)) {
                $filter = $filter->where('area_size', '<=', $maxArea);
            }
            else {
                $filter = $filter->where('area_size', '>=', $minArea)->where('area_size', '<=', $maxArea);
            }
        }
        if (!empty($minFloor) || !empty($maxFloor)) {
            if (!empty($minFloor)) {
                $filter = $filter->where('floor', '>=', $minFloor);
            }
            elseif (!empty($maxFloor)) {
                $filter = $filter->where('floor', '<=', $maxFloor);
            }
            else {
                $filter = $filter->where('floor', '>=', $minFloor)->where('floor', '<=', $maxFloor);
            }
        }
        if (!empty($furnitureFlag)) {
            $filter = $filter->where('with_furniture', true);
        }
        if (!empty($parkingFlag)) {
            $filter = $filter->where('with_parking', true);
        }
        if (!empty($petsFlag)) {
            $filter = $filter->where('with_pets', true);
        }
        if (!empty($childrenFlag)) {
            $filter = $filter->where('with_children', true);
        }
        if (!empty($elevatorFlag)) {
            $filter = $filter->where('with_elevator', true);
        }
        if (!empty($basementFlag)) {
            $filter = $filter->where('floor', $basementFlag);
        }
        if (!empty($penthouseFlag)) {
            $filter = $filter->where('is_top_floor', true);
        }

        if (!empty($sortType)) {
            if ($sortType == "price|asc") {
                $filter->orderBy('price');
            }
            elseif ($sortType == 'price|desc') {
                $filter->orderByDesc('price');
            }
        }

        if (empty($filter)) {
            $filter = All()->where('is_published', true)->orderByDesc('price');
        }

        $count_offers = count($filter->get());
        $offers = $filter->where('is_published', true)->paginate($this->property('items'));

        return [
            "#offers" => $this->renderPartial($this.'::list-partial', ['offers' => $offers]),
            "#searchCounter" => $this->renderPartial($this.'::counter-partial', ['offers_count' => $count_offers])
        ];
    }
}
