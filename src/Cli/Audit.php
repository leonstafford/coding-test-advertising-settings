<?php

/**
 * AdvertisingSettings.php
 *
 * @package           AdvertisingSettings
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 */

declare(strict_types=1);

namespace AdvertisingSettings\Cli;

use WP_CLI;

/**
 * Implements WP-CLI audit command.
 */
class Audit
{
    /**
     * Prints information about which posts have advertising settings.
     *
     * ## EXAMPLES
     *
     *     wp advertising-settings audit
     *
     * @when after_wp_load
     *
     * @return void
     */
    public function audit()
    {
        // Print the message.
        WP_CLI::line('TODO: print out CLI info');
    }
}
