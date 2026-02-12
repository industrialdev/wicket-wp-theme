<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WicketTheme\Theme;

/**
 * Theme class tests
 */
class ThemeTest extends TestCase
{
    public function test_version_returns_string(): void
    {
        $version = Theme::version();

        $this->assertIsString($version);
        $this->assertNotEmpty($version);
    }

    public function test_version_format(): void
    {
        $version = Theme::version();

        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', $version, 'Version should follow semantic versioning');
    }

    public function test_isActive_returns_boolean(): void
    {
        $isActive = Theme::isActive();

        $this->assertIsBool($isActive);
    }
}
