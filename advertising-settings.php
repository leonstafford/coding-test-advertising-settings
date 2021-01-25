<?php

/**
 * Plugin Name
 *
 * @package           AdvertisingSettings
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 *
 * @wordpress-plugin
 * Plugin Name:       Advertising Settings
 * Plugin URI:        https://github.com/leonstafford/coding-test-advertising-settings
 * Description:       Gutenberg block to control advertising settings.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:      Leon Stafford
 * Author URI:  https://ljs.dev
 * Text Domain:       advertising-settings
 * License:           The Unlicense
 * License URI:       https://unlicense.org
 */

declare(strict_types=1);

namespace AdvertisingSettings;

// Prevent direct execution.
if (! defined('ABSPATH')) {
    die;
}

// Load autoloader.
if (! class_exists(\AdvertisingSettings\Config::class) && is_file(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Prevent double activation.
if (\AdvertisingSettings\Config::get('version') !== null) {
    add_action(
        'admin_notices',
        static function () {
            // phpcs:ignore Squiz.PHP.DiscouragedFunctions.Discouraged
            error_log('Advertising Settings double activation. Please remove all but one copies. ' . __FILE__);

            if (! current_user_can('activate_plugins')) {
                return;
            }

            printf(
                '<div class="notice notice-warning"><p>%1$s<br>%2$s&nbsp;<code>%3$s</code></p></div>',
                esc_html__(
                    'Advertising Settings already installed! Please deactivate all but one copies.',
                    'advertising-settings'
                ),
                esc_html__('Current plugin path:', 'advertising-settings'),
                esc_html(__FILE__)
            );
        },
        0,
        0
    );
    return;
}

// Define constant values.
\AdvertisingSettings\Config::init(
    [
        'version' => '0.0.1',
        'filePath' => __FILE__,
        'baseName' => plugin_basename(__FILE__),
        'slug' => 'advertising-settings',
    ]
);

// Check requirements.
if (
    (new \AdvertisingSettings\Requirements())
        ->php('7.3')
        ->wp('5.2')
        ->multisite(false)
        ->met()
) {
    // Hook plugin activation functions.
    register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate');
    register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate');
    register_uninstall_hook(__FILE__, __NAMESPACE__ . '\\uninstall');
    add_action('plugins_loaded', __NAMESPACE__ . '\\boot', 10, 0);

    // Support WP-CLI.
    if (defined('WP_CLI') && \WP_CLI === true) {
        \AdvertisingSettings\registerCliCommands();
    }
} else {
    // Suppress "Plugin activated." notice.
    unset($_GET['activate']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

    add_action('admin_notices', __NAMESPACE__ . '\\printRequirementsNotice', 0, 0);

    require_once \ABSPATH . 'wp-admin/includes/plugin.php';
    deactivate_plugins([\AdvertisingSettings\Config::get('baseName')], true);
}

// Load translations.
add_action('init', __NAMESPACE__ . '\\loadTextDomain', 10, 0);
