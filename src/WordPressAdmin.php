<?php
/*
    WordPressAdmin

    AdvertisingSettings's interface to WordPress Admin functions

    Used for registering hooks, Admin UI components, ...
*/

namespace AdvertisingSettings;

class WordPressAdmin {

    /**
     * WordPressAdmin constructor
     */
    public function __construct() {

    }

    /**
     * Register hooks for WordPress and AdvertisingSettings actions
     *
     * @param string $bootstrap_file main plugin filepath
     */
    public static function registerHooks( string $bootstrap_file ) : void {
        register_activation_hook(
            $bootstrap_file,
            [ Controller::class, 'activate' ]
        );

        register_deactivation_hook(
            $bootstrap_file,
            [ Controller::class, 'deactivate' ]
        );

        // TODO: placeholder filter
        // add_filter(
        //     'advertising_settings_do_something',
        //     [ CrawlCache::class, 'advertising_settings_do_something' ]
        // );
}

