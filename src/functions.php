<?php

/**
 * functions.php - Procedural part of Advertising Settings.
 *
 * @package           AdvertisingSettings
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 */

declare(strict_types=1);

namespace AdvertisingSettings;

use AdvertisingSettings\ExampleCommand;
use WP_CLI;

use function current_user_can;
use function esc_html__;
use function esc_url;
use function load_plugin_textdomain;

/**
 * @return void
 */
function loadTextDomain()
{
    load_plugin_textdomain('plugin-slug', false, dirname(Config::get('baseName')) . '/languages');
}

/**
 * @return void
 */
function activate()
{
    // Run database migrations, initialize WordPress options etc.
}

/**
 * @return void
 */
function deactivate()
{
    // Do something related to deactivation.
}

/**
 * @return void
 */
function uninstall()
{
    // Remove custom database tables, WordPress options etc.
}

/**
 * @return void
 */
function printRequirementsNotice()
{
    // phpcs:ignore Squiz.PHP.DiscouragedFunctions.Discouraged
    error_log('Plugin Name requirements are not met. Please read the Installation instructions.');

    if (! current_user_can('activate_plugins')) {
        return;
    }

    printf(
        '<div class="notice notice-error"><p>%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s</p></div>',
        esc_html__('Plugin Name activation failed! Please read', 'plugin-slug'),
        esc_url('https://github.com/szepeviktor/small-project#installation'),
        esc_html__('the Installation instructions', 'plugin-slug'),
        esc_html__('for list of requirements.', 'plugin-slug')
    );
}

/**
 * @return void
 */
function registerCliCommands()
{
    WP_CLI::add_command('advertising-settings', Audit::class);
}

/**
 * Start!
 *
 * @return void
 */
function boot()
{
    new AdvertisingSettings();
}
