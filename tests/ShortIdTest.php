<?php

namespace Tests;

use ByJG\ShortId\ShortId;
use PHPUnit\Framework\TestCase;

class ShortIdTest extends TestCase
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
     * @dataProvider dataProviderNumber
     */
    public function testGetFromShortId($from, $expected)
    {
        $this->assertEquals(
            $expected,
            ShortId::get($from)
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

    public function testFromUuid()
    {
        ShortId::fromRandom();  // Just run to see if it works

        $this->assertEquals('a2BU6bLxLieeALmbPW3QuK', ShortId::fromUuid('092395A6-BC87-11ED-8CA9-0242AC120002'));
        $this->assertEquals('OKgJdeLxLieeALmbPW3QuK', ShortId::fromUuid('092609DD-BC87-11ED-8CA9-0242AC120002'));
    }
}
