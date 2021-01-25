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

use Composer\InstalledVersions;

use function get_option;
use function get_site_option;
use function get_template;
use function is_multisite;

/**
 * Check plugin requirements.
 */
class Requirements
{
    protected bool $met;

    /**
     * @return void
     */
    public function __construct()
    {
        // By default there is no problem.
        $this->met = true;
    }

    public function met(): bool
    {
        return $this->met;
    }

    public function php(string $minVersion): self
    {
        $this->met = $this->met && version_compare(PHP_VERSION, $minVersion, '>=');

        return $this;
    }

    public function wp(string $minVersion): self
    {
        // Makes $wp_version available locally.
        require \ABSPATH . \WPINC . '/version.php';

        /** @var string $wp_version */
        $this->met = $this->met && version_compare($wp_version, $minVersion, '>='); // phpcs:ignore

        return $this;
    }

    public function multisite(bool $required): self
    {
        $this->met = $this->met && (!$required || is_multisite());

        return $this;
    }

    /**
     * @param list<string> $plugins
     */
    public function plugins(array $plugins): self
    {
        $this->met = $this->met && array_reduce(
            $plugins,
            function (bool $active, string $plugin): bool {
                return $active && $this->isPluginActive($plugin);
            },
            true
        );

        return $this;
    }

    public function theme(string $parentTheme): self
    {
        $this->met = $this->met && get_template() === $parentTheme;

        return $this;
    }

    /**
     * @param list<string> $packages
     */
    public function packages(array $packages): self
    {
        $this->met = $this->met && array_reduce(
            $packages,
            static function (bool $installed, string $package): bool {
                return $installed && InstalledVersions::isInstalled($package);
            },
            true
        );

        return $this;
    }

    /**
     * Copy of core's is_plugin_active()
     */
    protected function isPluginActive(string $plugin): bool
    {
        return in_array($plugin, (array)get_option('active_plugins', []), true)
            || $this->isPluginActiveForNetwork($plugin);
    }

    /**
     * Copy of core's is_plugin_active_for_network()
     */
    protected function isPluginActiveForNetwork(string $plugin): bool
    {
        if (! is_multisite()) {
            return false;
        }

        $plugins = get_site_option('active_sitewide_plugins');
        if (isset($plugins[$plugin])) { // phpcs:ignore
            return true;
        }

        return false;
    }
}
