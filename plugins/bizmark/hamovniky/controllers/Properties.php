<?php namespace BizMark\Hamovniky\Controllers;

use BackendMenu;
use System\Classes\SettingsManager;
use Backend\Classes\Controller;

/**
 * Properties Back-end Controller
 */
class Properties extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('BizMark.Hamovniky', 'hamovniky_properties');
    }
}
