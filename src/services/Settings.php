<?php
/**
 * CMC-Gql plugin for Craft CMS 3.x
 *
 * Campaign Monitor Connector GQL plugin for Craft CMS 3.x
 *
 * @link      dorineallali.com
 * @copyright Copyright (c) 2021 Dorine Allali
 */

namespace dorineal\cmcgql\services;

use dorineal\cmcgql\CMCGql;

use Craft;
use craft\base\Component;

/**
 * @author    Dorine Allali
 * @package   CMCGql
 * @since     1.0.0
 */
class Settings extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (CMCGql::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
