<?php

namespace Tests;

use ByJG\Utils\ShortId;

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class ShortIdTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider dataProviderNumber
     */
    public function testFromNumber($expected, $from)
    {
        $this->assertEquals(
            $expected,
            ShortId::fromNumber($from)
        );
    }

    /**
     * @dataProvider dataProviderHex
     */
    public function testFromHex($expected, $from)
    {
        $this->assertEquals(
            $expected,
            ShortId::fromHex($from)
        );
    }

    public function dataProviderNumber()
    {
        return [
            ['a', 0],
            ['b', 1],
            ['ab', 62],
            ['ac', 2*62],
            ['aA', 26*62],
            ['a0', 52*62],
            ['aab', 62*62],
        ];
    }

    public function dataProviderHex()
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

    // public function testFromHex()
    // {
    //
    // }
}
