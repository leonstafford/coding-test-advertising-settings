<?php

/**
 * AdvertisingSettingsTest.php
 *
 * @package           AdvertisingSettings
 * @author            Leon Stafford <me@ljs.dev>
 * @license           The Unlicense
 * @link              https://unlicense.org
 */

declare(strict_types=1);

namespace AdvertisingSettings;

use Mockery;
use WP_Mock;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class AdvertisingSettingsTest extends \WP_Mock\Tools\TestCase
{

    public function setUp(): void
    {
        WP_Mock::setUp();
    }

    public function tearDown(): void
    {
        WP_Mock::tearDown();
        Mockery::close();
    }
}
