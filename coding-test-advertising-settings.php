<?php

declare(strict_types=1);

/**
 * Plugin Name: Advertising Settings
 * Plugin URI:  https://github.com/leonstafford/coding-test-advertising-settings
 * Description: Gutenberg block to control advertising settings.
 * Version:     0.0.1
 * Author:      Leon Stafford
 * Author URI:  https://ljs.dev
 *
 * @package     AdvertisingSettings
 */

if (! defined('ABSPATH')) {
    die;
}

define('ADVERTISINGSETTINGS_VERSION', '0.0.1');
define('ADVERTISINGSETTINGS_PATH', plugin_dir_path(__FILE__));

if (file_exists(ADVERTISINGSETTINGS_PATH . 'vendor/autoload.php')) {
    require_once ADVERTISINGSETTINGS_PATH . 'vendor/autoload.php';
}

if (! class_exists('AdvertisingSettings\Controller')) {
    if (file_exists(ADVERTISINGSETTINGS_PATH . 'src/AdvertisingSettingsException.php')) {
        require_once ADVERTISINGSETTINGS_PATH . 'src/AdvertisingSettingsException.php';

        throw new \AdvertisingSettings\AdvertisingSettingsException(
            'Looks like you\'re trying to activate AdvertisingSettings from source code' .
            ', without compiling it first. Please see' .
            ' https://github.com/leonstafford/coding-test-advertising-standards for instructions.'
        );
    }
}

AdvertisingSettings\Controller::init(__FILE__);

/**
 * Define Settings link for plugin
 *
 * @param array<string> $links array of links
 * @return array<string> modified array of links
 */
function plugin_action_links( $links )
{
    $settings_link =
        '<a href="admin.php?page=advertising-settings">' .
        __('Settings', 'advertising-settings') .
        '</a>';
    array_unshift($links, $settings_link);

    return $links;
}

add_filter(
    'plugin_action_links_' .
    plugin_basename(__FILE__),
    'plugin_action_links'
);

if (defined('WP_CLI')) {
    WP_CLI::add_command('advertising-settings', AdvertisingSettings\CLI::class);
}
