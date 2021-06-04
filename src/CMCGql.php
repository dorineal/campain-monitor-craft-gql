<?php
/**
 * CMC-Gql plugin for Craft CMS 3.x
 *
 * Campaign Monitor Connector GQL plugin for Craft CMS 3.x
 *
 * @link      dorineallali.com
 * @copyright Copyright (c) 2021 Dorine Allali
 */

namespace dorineal\cmcgql;

use dorineal\cmcgql\services\Settings as SettingsService;
use dorineal\cmcgql\services\CampaignMonitorService;
use dorineal\cmcgql\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use craft\services\Gql;
use GraphQL\Type\Definition\Type;

use yii\base\Event;

/**
 * Class CMCGql
 *
 * @author    Dorine Allali
 * @package   CMCGql
 * @since     1.0.0
 *
 * @property  SettingsService $settings
 */
class CMCGql extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CMCGql
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'campaignMonitor' => CampaignMonitorService::class,
        ]);

        $this->campaignMonitor->init();

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'cmc-gql/settings';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                // $event->rules['cmc-gql/settings'] = 'cmc-gql/settings/index';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        // Event::on(
        //     Gql::class,
        //     Gql::EVENT_REGISTER_GQL_QUERIES,
        //     [$this, 'registerGqlQueries']
        // );

        Event::on(
            Gql::class,
            Gql::EVENT_REGISTER_GQL_MUTATIONS,
            [$this, 'registerGqlMutations']
        );

        Craft::info(
            Craft::t(
                'cmc-gql',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    public function registerGqlMutations(Event $event)
    {
        /** @var Users */
        $usersService = Craft::$app->getUsers();

        /** @var Elements */
        $elements = Craft::$app->getElements();

        /** @var Settings */
        $settings = CMCGql::$plugin->getSettings();

        $event->mutations['subscribeUserToNewsletter'] = [
            'description' => 'Subscribe the user to the newsletter.',
            'type' => Type::boolean(),
            'args' => [
                'email' => Type::nonNull(Type::string())
            ],
            'resolve' => function ($source, array $arguments) use (
                    $usersService, $elements, $settings
                ) {
                $return = false;

                $email = $arguments['email'];
                $firstName = "";
                $lastName ="";
                $name = "";
                $customFields = [];

                $user = $usersService->getUserByUsernameOrEmail($email);

                if ($user) {
                    $firstName = $user->firstName;
                    $lastName = $user->lastName;
                    $name = $firstName . ' ' . $lastName;

                    $listCustomFields = $this->campaignMonitor->getListCustomFields(
                        $settings->getListId()
                    );

                    if ($listCustomFields['success'] && count($listCustomFields['body']) > 0) {
                        foreach ($listCustomFields['body'] as $field) {
                            if (isset($user->{$field->FieldName})) {
                                array_push(
                                    $customFields,
                                    [
                                        "Key" => $field->Key,
                                        "Value" => $user->{$field->FieldName}
                                    ]
                                );
                            }
                        }
                    }
                }

                $success = $this->campaignMonitor->addSubscriber(
                    CMCGql::$plugin->getSettings()->getListId(),
                    [
                        "EmailAddress" => $arguments['email'],
                        "Name" => $name,
                        "CustomFields" => $customFields,
                        "Resubscribe" => true,
                        "RestartSubscriptionBasedAutoresponders" => true,
                        "ConsentToTrack" => "Yes"
                    ]
                );

                if ($success) {
                    if ($user && isset($user->isRegisteredToTheNewsletter)) {
                        $user->setFieldValue('isRegisteredToTheNewsletter', true);
                        if (!$elements->saveElement($user)) {
                            $return = false;
                        }
                    }
                    $return = true;
                }

                return $return;
            },
        ];
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'cmc-gql/settings',
            $this->getAllSettings()
        );
    }

    protected function getAllSettings() {
        $settings = CMCGql::$plugin->getSettings();
        $lists = [];
        $namespace = 'settings';

        if ($settings->apiKey && $settings->clientId) {
            $campaignMonitorService = CMCGql::$plugin->getInstance()->campaignMonitor;
            $campaignMonitorLists = $campaignMonitorService->getLists();


            $lists = [
                [
                    'label' => '--',
                    'value' => null
                ]
            ];

            foreach ($campaignMonitorLists['body'] as $list) {
                array_push(
                    $lists,
                    [
                        'label' => $list->Name,
                        'value' => $list->ListID
                    ]
                );
            }
        }

        return compact(
            'settings', 'namespace', 'lists'
        );
    }
}
