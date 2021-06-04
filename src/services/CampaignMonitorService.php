<?php

/**
 * @link      https://github.com/clearbold/craft-campaignmonitor-lsynchists
 * @copyright Copyright (c) Clearbold, LLC
 *
 * Synch your Craft members or "people" entries with your Campaign Monitor subscriber lists.
 *
 */

namespace dorineal\cmcgql\services;

use Craft;
use craft\base\Component;
use dorineal\cmcgql\CMCGql;
/**
 * @author    Mark Reeves
 * @since     0.1.0
 */
class CampaignMonitorService extends Component
{
  /**
   * @var string
   */
  private $apiKey;

  /**
   * @var string
   */
  private $clientId;

  // Public Methods
  // =========================================================================

  /**
   * @inheritdoc
   */
  public function init()
  {
    parent::init();

    $settings = CMCGql::$plugin->getSettings();
    $this->apiKey = $settings->getApiKey();
    $this->clientId = $settings->getClientId();
  }

  /*
     * @return mixed
     */
  public function getLists()
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Clients(
        $this->clientId,
        $auth
      );

      $result = $client->get_lists();

      if ($result->was_successful()) {
        $body = array();
        foreach ($result->response as $list) {
          $body[] = $list;
        }
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $body
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response->Code . ' ' . $result->response->Message
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  public function getList($listId = '')
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Lists(
        $listId,
        $auth
      );

      $result = $client->get();

      if ($result->was_successful()) {
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $result->response
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  public function getListCustomFields($listId = '')
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Lists(
        $listId,
        $auth
      );

      $result = $client->get_custom_fields();

      if ($result->was_successful()) {
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $result->response
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  public function getActiveSubscribers($listId = '', $params = [])
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Lists(
        $listId,
        $auth
      );

      $result = $client->get_active_subscribers('', 1, 10, 'date', 'desc');

      if ($result->was_successful()) {
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $result->response->Results
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  public function getListsForEmail($email = '', $params = [])
  {
    $settings = CMCGql::$plugin->getSettings();

    try {
      $auth = array(
        'api_key' => (string)$settings->apiKey
      );
      $client = new \CS_REST_Clients(
        $settings->clientId,
        $auth
      );

      $result = $client->get_lists_for_email($email);

      if ($result->was_successful()) {
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $result->response
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  /*
     * @return mixed
     */
  public function addSubscriber($listId = '', $subscriber = array())
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Subscribers(
        $listId,
        $auth
      );
      $result = $client->add($subscriber);

      if ($result->was_successful()) {
        $body = $result->response;
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $body
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response->Message
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }

  public function unsubSubscriber($listId = '', $email = '')
  {
    try {
      $auth = [
        'api_key' => $this->apiKey,
      ];

      $client = new \CS_REST_Subscribers(
        $listId,
        $auth
      );
      $result = $client->unsubscribe($email);

      if ($result->was_successful()) {
        $body = $result->response;
        return [
          'success' => true,
          'statusCode' => $result->http_status_code,
          'body' => $body
        ];
      } else {
        return [
          'success' => false,
          'statusCode' => $result->http_status_code,
          'reason' => $result->response->Message
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => false,
        'reason' => $e->getMessage()
      ];
    }
  }
}
