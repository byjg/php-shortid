<?php

namespace Tests;

use ByJG\ShortId\ShortId;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ShortIdTest extends TestCase
{

    #[DataProvider('dataProviderNumber')]
    public function testFromNumber($expected, $from)
    {
        $this->assertEquals(
            $expected,
            ShortId::fromNumber($from)
        );
    }

    #[DataProvider('dataProviderNumber')]
    public function testGetFromShortId($from, $expected)
    {
        $this->assertEquals(
            $expected,
            ShortId::get($from)
        );
    }

    #[DataProvider('dataProviderHex')]
    public function testFromHex($expected, $from)
    {
        $this->assertEquals(
            $expected,
            ShortId::fromHex($from)
        );
    }

    public function testFromHexLargestValue()
    {
        $this->assertSame('hWifIaXiv9k', ShortId::fromHex('7fffffffffffffff'));
        $this->assertSame(ShortId::fromNumber(PHP_INT_MAX), ShortId::fromHex('7fffffffffffffff'));
    }

    public function testFromHexValueTooLarge()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('fromUuid()');
        ShortId::fromHex('8000000000000000');
    }

    public function testGetRoundTripsLargestInteger()
    {
        $this->assertSame(PHP_INT_MAX, ShortId::get(ShortId::fromNumber(PHP_INT_MAX)));
        $this->assertSame(PHP_INT_MAX, ShortId::get(ShortId::fromHex('7fffffffffffffff')));
    }

    public function testGetRoundTripsLargeValues()
    {
        $values = [PHP_INT_MAX - 1, 2 ** 53 + 1, 2 ** 62, 62 ** 10];
        for ($i = 0; $i < 100; $i++) {
            $values[] = random_int(2 ** 53, PHP_INT_MAX);
        }

        foreach ($values as $value) {
            $this->assertSame($value, ShortId::get(ShortId::fromNumber($value)), "Round trip of $value");
            $this->assertSame($value, ShortId::get(ShortId::fromNumber($value, ShortId::$MAP_RANDOM), ShortId::$MAP_RANDOM));
        }
    }

    public static function dataProviderTooLarge()
    {
        return [
            'PHP_INT_MAX + 1' => ['iWifIaXiv9k'],
            'PHP_INT_MAX + 62^10' => ['hWifIaXiv9l'],
            'twelve digits' => ['aaaaaaaaaaab'],
        ];
    }

    #[DataProvider('dataProviderTooLarge')]
    public function testGetValueTooLarge(string $shortId)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('greater than the largest integer');
        ShortId::get($shortId);
    }

    public static function dataProviderNumber()
    {
        return [
            ['a', 0],
            ['b', 1],
            ['ab', 62],
            ['ac', 2*62],
            ['aA', 26*62],
            ['a0', 52*62],
            ['aab', 62*62],
            // Above 2^53, where float arithmetic loses precision
            ['NdmVYMvykxb', 2**60 + 12345],
            ['Rx4pXbSumDb', 1234567890123456789],
            ['eyJcrFyJPEf', 2**62],
            ['hWifIaXiv9k', PHP_INT_MAX],
        ];
    }

    public static function dataProviderHex()
    {
        return [
            ['a', '0'],
            ['b', '1'],
            ['ab', '3e'],
            ['ac', '7c'],
            ['aA', '64c'],
            ['a0', 'c98'],
            ['aab', 'f04'],
        ];
    }

    public function testFromUuid()
    {
        ShortId::fromRandom();  // Just run to see if it works

        $this->assertEquals('a2BU6bLxLieeALmbPW3QuK', ShortId::fromUuid('092395A6-BC87-11ED-8CA9-0242AC120002'));
        $this->assertEquals('OKgJdeLxLieeALmbPW3QuK', ShortId::fromUuid('092609DD-BC87-11ED-8CA9-0242AC120002'));
    }

    public function testWithCustomMap()
    {
        // Test with the predefined random map
        $customMap = ShortId::$MAP_RANDOM;

        // Test encoding and decoding with custom map
        $testNumbers = [0, 1, 62, 124, 1000, 999999];

        foreach ($testNumbers as $number) {
            $encoded = ShortId::fromNumber($number, $customMap);
            $decoded = ShortId::get($encoded, $customMap);

            $this->assertEquals($number, $decoded, "Failed to encode/decode $number with custom map");
        }
    }

    public function testWithAlternateMaps()
    {
        // Test with MAP_ALTERNATE
        $encoded = ShortId::fromNumber(100, ShortId::$MAP_ALTERNATE);
        $decoded = ShortId::get($encoded, ShortId::$MAP_ALTERNATE);
        $this->assertEquals(100, $decoded);

        // Test with MAP_NUMBERS_FIRST
        $encoded = ShortId::fromNumber(100, ShortId::$MAP_NUMBERS_FIRST);
        $decoded = ShortId::get($encoded, ShortId::$MAP_NUMBERS_FIRST);
        $this->assertEquals(100, $decoded);

        // Test that different maps produce different encodings
        $number = 999999;
        $default = ShortId::fromNumber($number, ShortId::$MAP_DEFAULT);
        $numbersFirst = ShortId::fromNumber($number, ShortId::$MAP_NUMBERS_FIRST);
        $random = ShortId::fromNumber($number, ShortId::$MAP_RANDOM);

        // MAP_DEFAULT and MAP_ALTERNATE only differ in uppercase/numbers order,
        // so they produce same result for numbers that only use lowercase letters
        // MAP_NUMBERS_FIRST should differ (numbers are at the start)
        $this->assertNotEquals($default, $numbersFirst);

        // MAP_RANDOM should differ from all others
        $this->assertNotEquals($default, $random);
        $this->assertNotEquals($numbersFirst, $random);
    }

    public function testFromHexWithCustomMap()
    {
        $customMap = ShortId::$MAP_RANDOM;

        $encoded = ShortId::fromHex('3e', $customMap);
        $decoded = ShortId::get($encoded, $customMap);

        $this->assertEquals(62, $decoded);
    }
}
