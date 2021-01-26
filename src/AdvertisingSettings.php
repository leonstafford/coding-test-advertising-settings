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

        add_action(
            'init',
            [$this, 'advertising_settings_register_meta']
        );

        add_filter(
            'rest_post_dispatch',
            [$this, 'log_rest_api_errors'],
            10,
            3
        );
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
            'advertising_settings_advertisements_metafield',
            [
                'show_in_rest' => true,
                'type' => 'boolean',
                'single' => true,
                // 'sanitize_callback' => 'sanitize_text_field',
                // 'auth_callback' => function() { 
                //      return current_user_can('edit_posts');
                // }
            ]
        );

        register_meta(
            'post',
            'advertising_settings_commercial_content_type_metafield',
            [
                'show_in_rest' => true,
                'type' => 'string',
                'single' => true,
            ]
        );

        register_meta(
            'post',
            'advertising_settings_advertiser_name_metafield',
            [
                'show_in_rest' => true,
                'type' => 'string',
                'single' => true,
            ]
        );
    }

    /**
     * Log REST API errors
     *
     * @param WP_REST_Response $result  Result that will be sent to the client.
     * @param WP_REST_Server   $server  The API server instance.
     * @param WP_REST_Request  $request The request used to generate the response.
     */
    public function log_rest_api_errors( $result, $server, $request ) {
        if ( $result->is_error() ) {
            error_log( sprintf(
                "REST request: %s: %s",
                $request->get_route(),
                print_r( $request->get_params(), true )
            ) );

            error_log( sprintf(
                "REST result: %s: %s",
                $result->get_matched_route(),
                print_r( $result->get_data(), true )
            ) );
        }

        return $result;
    }
}
