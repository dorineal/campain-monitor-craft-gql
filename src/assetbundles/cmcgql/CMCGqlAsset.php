<?php
/**
 * CMC-Gql plugin for Craft CMS 3.x
 *
 * Campaign Monitor Connector GQL plugin for Craft CMS 3.x
 *
 * @link      dorineallali.com
 * @copyright Copyright (c) 2021 Dorine Allali
 */

namespace dorineal\cmcgql\assetbundles\cmcgql;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Dorine Allali
 * @package   CMCGql
 * @since     1.0.0
 */
class CMCGqlAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@dorineal/cmcgql/assetbundles/cmcgql/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CMCGql.js',
        ];

        $this->css = [
            'css/CMCGql.css',
        ];

        parent::init();
    }
}
