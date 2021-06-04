# CMC-Gql plugin for Craft CMS 3.x

Campaign Monitor Connector GQL plugin for Craft CMS 3.x

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1.  Open your terminal and go to your Craft project:

        cd /path/to/project

2.  Then tell Composer to load the plugin:

        composer require dorineal/cmc-gql

3.  In the Control Panel, go to Settings → Plugins and click the “Install” button for CMC-Gql.

## CMC-Gql Overview

-Insert text here-

## Configuring CMC-Gql

Fields to add to Craft CMS:

You can add the boolean field `isRegisteredToTheNewsletter` to your user custom fields if you want to keep track in the admin of which users are registered to the newsletter.

## Using CMC-Gql

If you want to link your custom user fields to the custom fields in campaign monitor, you just have to create custom fields in your campaign monitor list that have the exact same name as the custom user fields in craft. It will automatically add the data to campaign monitor if it exists.

## CMC-Gql Roadmap

Some things to do, and ideas for potential features:

- Release it

Brought to you by [Dorine Allali](dorineallali.com)
