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

/**
 * Plugin main instance
 */
final class AdvertisingSettings
{
    public function __construct()
    {
        if( is_admin() ){
            add_action(
                'enqueue_block_editor_assets',
                [$this, 'enqueue_admin_scripts']
            );
        }
    }

    public function enqueue_admin_scripts(): void
    {
        wp_enqueue_script(
            'advertising-settings-admin-js',
            plugins_url( '../build/index.js', __FILE__ ),
            [ 'wp-plugins', 'wp-edit-post', 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ],
            (string)filemtime( plugin_dir_path( __FILE__ ) . '/index.js' )   
        );
    }
}
