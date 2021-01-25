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

use WP_CLI;

use function current_user_can;
use function esc_html__;

/**
 * @return void
 */
function activate()
{
    \AdvertisingSettings\AsLog::createTable();
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
    error_log('Advertising Settings requirements are not met. Please read the Installation instructions.');

    if (! current_user_can('activate_plugins')) {
        return;
    }

    printf(
        '<div class="notice notice-error"><p>%1$s</p></div>',
        esc_html__('Advertising Settings activation failed!', 'advertising-settings'),
    );
}

/**
 * @return void
 */
function registerCliCommands()
{
    WP_CLI::add_command('advertising-settings', \AdvertisingSettings\Cli\Audit::class);
}

/**
 * Start!
 *
 * @return void
 */
function boot()
{
    new \AdvertisingSettings\AdvertisingSettings();
}
