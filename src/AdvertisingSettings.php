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

            add_action(
                'init',
                [$this, 'advertising_settings_register_meta']
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

    public function advertising_settings_register_meta(): void
    {
        register_meta(
            'post',
            '_advertising_settings_advertisements_metafield',
            [
                'show_in_rest' => true,
                'type' => 'boolean',
                'single' => true,
            ]
        );

        register_meta(
            'post',
            '_advertising_settings_commercial_content_type_metafield',
            [
                'show_in_rest' => true,
                'type' => 'string',
                'single' => true,
            ]
        );

        register_meta(
            'post',
            '_advertising_settings_advertiser_name_metafield',
            [
                'show_in_rest' => true,
                'type' => 'string',
                'single' => true,
            ]
        );
    }
}
