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

namespace AdvertisingSettings;

use AsLog;

/**
 * Plugin main instance
 */
final class AdvertisingSettings
{
    public string $boostrapFile;

    /**
     * Main controller of AdvertisingSettings
     *
     * @var \AdvertisingSettings\AdvertisingSettings Instance.
     */
    protected static ?\AdvertisingSettings\AdvertisingSettings $pluginInstance;

    protected function __construct()
    {
    }

    /**
     * Returns instance of AdvertisingSettings AdvertisingSettings
     *
     * @return \AdvertisingSettings\AdvertisingSettings Instance of self.
     */
    public static function getInstance(): AdvertisingSettings
    {
        if (isset(self::$pluginInstance) === false) {
            self::$pluginInstance = new self();
        }

        return self::$pluginInstance;
    }

    public static function init( string $boostrapFile ): AdvertisingSettings
    {
        $pluginInstance = self::getInstance();

        AsLog::l('Plugin controller initialized');

        return $pluginInstance;
    }

    /**
     * Adjusts position of dashboard menu icons
     *
     * @param array<string> $menuOrder list of menu items
     * @return array<string> list of menu items
     */
    public static function setMenuOrder( array $menuOrder ): array
    {
        $order = [];

        // phpcs:ignore
        foreach ($menuOrder as $index => $item) {
            if ($item !== 'index.php') {
                continue;
            }

            $order[] = $item;
        }

        return [
            'index.php',
            'advertising-settings',
        ];
    }

    public static function deactivateForSingleSite(): void
    {
        AsLog::l('deactiving for single site');
    }

    public static function deactivate( ?bool $networkWide = null ): void
    {
        if ($networkWide) {
            global $wpdb;

            $siteIDs = $wpdb->get_col(
                $wpdb->prepare(
                    'SELECT blog_id FROM %s WHERE site_id = %d;',
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ($siteIDs as $siteID) {
                switch_to_blog($siteID);
                self::deactivateForSingleSite();
            }

            restore_current_blog();
        } else {
            self::deactivateForSingleSite();
        }
    }

    public static function activateForSingleSite(): void
    {
        AsLog::createTable();
        // TODO: do I need to prep the Post Meta table?
    }

    public static function activate( ?bool $networkWide = null ): void
    {
        if ($networkWide) {
            global $wpdb;

            $siteIDs = $wpdb->get_col(
                $wpdb->prepare(
                    'SELECT blog_id FROM %s WHERE site_id = %d;',
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ($siteIDs as $siteID) {
                switch_to_blog($siteID);
                self::activateForSingleSite();
            }

            restore_current_blog();
        } else {
            self::activateForSingleSite();
        }
    }
}
