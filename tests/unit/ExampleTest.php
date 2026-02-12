<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Simple example test for Wicket WP Theme
 */
class ExampleTest extends TestCase
{
    public function test_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_array_contains_expected_values(): void
    {
        $expected = ['foo', 'bar'];
        $actual = ['foo', 'bar'];

        $this->assertEquals($expected, $actual);
    }
}
