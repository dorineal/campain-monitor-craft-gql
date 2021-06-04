<?php
/**
 * CMC-Gql plugin for Craft CMS 3.x
 *
 * Campaign Monitor Connector GQL plugin for Craft CMS 3.x
 *
 * @link      dorineallali.com
 * @copyright Copyright (c) 2021 Dorine Allali
 */

namespace dorineal\cmcgql\models;

use dorineal\cmcgql\CMCGql;

use Craft;
use craft\base\Model;

/**
 * @author    Dorine Allali
 * @package   CMCGql
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $apiKey = "";
    /**
     * @var string
     */
    public $clientId = "";
    /**
     * @var string
     */
    public $listId = "";

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiKey'], 'string'],
            [['clientId'], 'string'],
            [['listId'], 'string'],
        ];
    }

    /**
     * Retrieve parsed API Key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        if (Craft::parseEnv($this->apiKey)) {
            return Craft::parseEnv($this->apiKey);
        }

        return $this->apiKey;
    }

    /**
     * Retrieve parse Client Id
     *
     * @return string
     */
    public function getClientId(): string
    {
        if (Craft::parseEnv($this->clientId)) {
            return Craft::parseEnv($this->clientId);
        }

        return $this->clientId;
    }

    /**
     * Retrieve parse List Id
     *
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }
}
