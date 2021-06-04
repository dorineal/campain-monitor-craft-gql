<?php
/**
 * CMC-Gql plugin for Craft CMS 3.x
 *
 * Campaign Monitor Connector GQL plugin for Craft CMS 3.x
 *
 * @link      dorineallali.com
 * @copyright Copyright (c) 2021 Dorine Allali
 */

namespace dorineal\cmcgql\controllers;

use dorineal\cmcgql\CMCGql;

use Craft;
use craft\web\Controller;

/**
 * @author    Dorine Allali
 * @package   CMCGql
 * @since     1.0.0
 */
class SettingsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        // $settings = CMCGql::$plugin->getSettings();

        // $campaignMonitorService = CMCGql::$plugin->getInstance()->campaignMonitor;
        // $campaignMonitorLists = $campaignMonitorService->getLists();

        // $namespace = 'settings';

        // $lists = [
        //     [
        //         'label' => '--',
        //         'value' => null
        //     ]
        // ];

        // foreach ($campaignMonitorLists['body'] as $list) {
        //     array_push(
        //         $lists,
        //         [
        //             'label' => $list->Name,
        //             'value' => $list->ListID
        //         ]
        //     );
        // }

        // $this->renderTemplate('cmc-gql/settings', compact(
        //     'settings',
        //     'namespace',
        //     'lists'
        // ));
    }
}
