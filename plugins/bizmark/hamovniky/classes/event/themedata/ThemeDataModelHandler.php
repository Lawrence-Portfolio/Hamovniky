<?php namespace BizMark\Hamovniky\Classes\Event\ThemeData;

use Cms\Models\ThemeData;

/**
 * Class ThemeDataModelHandler
 * @package Bizmark\Hamovniki\Classes\Event\Product
 */
class ThemeDataModelHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        ThemeData::extend(function ($obElement) {
            $fields = [
                'main',
                'contacts',
                'about_us',
                'hamovniki',
                'consult'
            ];

            /** @var ThemeData $obElement */
            $obElement->addJsonable($fields);
        });
    }
}
