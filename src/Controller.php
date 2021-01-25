<?php

declare(strict_types=1);

namespace AdvertisingSettings;

class Controller
{
    public string $bootstrap_file;

    /**
     * Main controller of AdvertisingSettings
     *
     * @var \AdvertisingSettings\Controller Instance.
     */
    protected static ?\AdvertisingSettings\Controller $plugin_instance;

    protected function __construct()
    {
    }

    /**
     * Returns instance of AdvertisingSettings Controller
     *
     * @return \AdvertisingSettings\Controller Instance of self.
     */
    public static function getInstance(): Controller
    {
        if (isset(self::$plugin_instance) === false) {
            self::$plugin_instance = new self();
        }

        return self::$plugin_instance;
    }

    public static function init( string $bootstrap_file ): Controller
    {
        $plugin_instance = self::getInstance();

        WordPressAdmin::registerHooks($bootstrap_file);
        WordPressAdmin::addAdminUIElements();

        ASLog::l('Plugin controller initialized');

        Utils::set_max_execution_time();

        return $plugin_instance;
    }

    /**
     * Adjusts position of dashboard menu icons
     *
     * @param array<string> $menu_order list of menu items
     * @return array<string> list of menu items
     */
    public static function setMenuOrder( array $menu_order ): array
    {
        $order = [];
        $file = plugin_basename(__FILE__);

        foreach ($menu_order as $index => $item) {
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
        WPCron::clearRecurringEvent();
    }

    public static function deactivate( ?bool $network_wide = null ): void
    {
        if ($network_wide) {
            global $wpdb;

            $query = 'SELECT blog_id FROM %s WHERE site_id = %d;';

            $site_ids = $wpdb->get_col(
                sprintf(
                    $query,
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ($site_ids as $site_id) {
                switch_to_blog($site_id);
                self::deactivateForSingleSite();
            }

            restore_current_blog();
        } else {
            self::deactivateForSingleSite();
        }
    }

    public static function activateForSingleSite(): void
    {
        ASLog::createTable();
        // TODO: do I need to prep the Post Meta table?
    }

    public static function activate( ?bool $network_wide = null ): void
    {
        if ($network_wide) {
            global $wpdb;

            $query = 'SELECT blog_id FROM %s WHERE site_id = %d;';

            $site_ids = $wpdb->get_col(
                sprintf(
                    $query,
                    $wpdb->blogs,
                    $wpdb->siteid
                )
            );

            foreach ($site_ids as $site_id) {
                switch_to_blog($site_id);
                self::activateForSingleSite();
            }

            restore_current_blog();
        } else {
            self::activateForSingleSite();
        }
    }
}
