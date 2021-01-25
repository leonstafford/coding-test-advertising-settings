<?php

/**
 * Requirements.php
 *
 * @package           AdvertisingSettings
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 */

declare(strict_types=1);

namespace AdvertisingSettings;

/**
 * Logger.
 */
class ASLog
{
    public static function createTable(): void
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'advertising_settings_log';

        $charsetCollate = $wpdb->get_charsetCollate();

        $sql = $wpdb->prepare(
            'CREATE TABLE %s (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            log TEXT NOT NULL,
            PRIMARY KEY  (id)
        ) %s;',
            $tableName,
            $charsetCollate
        );

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        // phpcs:ignore
        dbDelta($sql);
    }

    public static function l( string $text ): void
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'advertising_settings_log';

        $wpdb->insert(
            $tableName,
            [
                'log' => $text,
            ]
        );

        if (!defined('WP_CLI')) {
            return;
        }

        $date = current_time('c');
        \WP_CLI::log(
            \WP_CLI::colorize("%W[$date] %n$text")
        );
    }

    /**
     * Get all log lines
     *
     * @return array<mixed> array of Log items
     */
    public static function getAll(): array
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'advertising_settings_log';

        return $wpdb->get_results($wpdb->prepare('SELECT time, log FROM %s ORDER BY id DESC', $tableName));
    }

    /**
     * Poll latest log lines
     */
    public static function poll(): string
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'advertising_settings_log';

        $logs = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT CONCAT_WS(': ', time, log)
            FROM %s
            ORDER BY id DESC",
                $tableName
            )
        );

        $logs = implode(PHP_EOL, $logs);

        return $logs;
    }

    /**
     *  Clear Log via truncation
     */
    public static function truncate(): void
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'advertising_settings_log';

        $wpdb->query($wpdb->prepare('TRUNCATE TABLE %s', $tableName));

        self::l('Deleted all Logs');
    }
}
