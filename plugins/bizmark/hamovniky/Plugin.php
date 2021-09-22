<?php namespace BizMark\Hamovniky;

use Backend, Event;
use System\Classes\PluginBase;
use BizMark\Hamovniky\Classes\Event\ThemeData\ThemeDataModelHandler;

/**
 * Hamovniky Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Хамовники',
            'description' => 'База объявлений о продаже и аренде квартир / домов / коммерческих помещений. ',
            'author'      => 'BizMark',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->addEventListeners();
        $this->registerConsoleCommand('hamovniky.cianupdate', 'Bizmark\Hamovniky\Console\CianUpdate');
    }

    protected function addEventListeners()
    {
        Event::subscribe(ThemeDataModelHandler::class);
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'BizMark\Hamovniky\Components\ServiceCatalog' => 'ServiceCatalog',
            'BizMark\Hamovniky\Components\ServiceItem' => 'ServiceItem',
            'BizMark\Hamovniky\Components\OfferCatalog' => 'OfferCatalog',
            'BizMark\Hamovniky\Components\OfferItem' => 'OfferItem',
            'BizMark\Hamovniky\Components\Favorites' => 'Favorites',
            'BizMark\Hamovniky\Components\FavoritesCatalog' => 'FavoritesCatalog',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'bizmark.hamovniky.some_permission' => [
                'tab' => 'Hamovniky',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'hamovniky_offers' => [
                'label'       => 'Объявления',
                'url'         => Backend::url('bizmark/hamovniky/offers'),
                'icon'        => 'icon-building-o',
                'permissions' => ['bizmark.hamovniky.*'],
                'order'       => 500,
            ],
            'hamovniky_services' => [
                'label'       => 'Услуги',
                'url'         => Backend::url('bizmark/hamovniky/services'),
                'icon'        => 'icon-list-ol',
                'permissions' => ['bizmark.hamovniky.*'],
                'order'       => 500,
            ],
        ];
    }

    /**
     * Registers back-end settings navigation items for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'hamovniky_properties' => [
                'label'       => 'Свойства',
                'description' => 'Задайте шаблонные свойства, для выбора в объявлениях.',
                'category'    => 'Объявления',
                'icon'        => 'icon-th-large',
                'url'         => Backend::url('bizmark/hamovniky/properties'),
                'order'       => 100,
                'keywords'    => 'свойства хамовники объявления'
            ]
        ];
    }

    /**
     * Registering additional twig functions
     *
     * @return array
     */
    public function registerMarkupTags() {
        return [
            'functions' => [
                'getQueryForPagination' => function ($query) {
                    unset($query['page']);
                    return http_build_query($query);
                }
            ]
        ];
    }
}
