<?php

namespace ByJG\Utils;

class ShortId
{
    public static $MAP_DEFAULT =
        "abcdefghijklmnopqrstuvwxyz"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
        . "0123456789"
    ;

    public static $MAP_ALTERNATE =
        "abcdefghijklmnopqrstuvwxyz"
        . "0123456789"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ;

    public static $MAP_NUMBERS_FIRST =
        "0123456789"
        . "abcdefghijklmnopqrstuvwxyz"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ;

    public static $MAP_RANDOM =
        "WPyHLMtE74KjUQvBqoS652uADF"
        . "gZibO9RdznT1YIVsXwfkaxCNpr"
        . "J3chmel0G8";

    public static function fromNumber($number, $map = null)
    {
        if (empty($map)) {
            $map = ShortId::$MAP_DEFAULT;
        }

        $size = strlen($map);
        $result = "";

        while ($number >= $size) {
            $mod = $number % $size;
            $number = intval($number / $size);
            $result .= $map[$mod];
        }
        $result .= $map[$number];

        return $result;
    }

    public static function fromHex($hex, $map = null)
    {
        $number = hexdec(str_replace('-', '', $hex));

        return self::fromNumber($number, $map);
    }

    public static function get($shortid, $map = null)
    {
        if (empty($map)) {
            $map = ShortId::$MAP_DEFAULT;
        }

        $base = strlen($map);
        $order = 1;
        $result = 0;

        for ($pos = 0; $pos < strlen($shortid); $pos++) {
            $result += intval(strpos($map, $shortid[$pos])) * $order;
            $order *= $base;
        }

        return $result;
    }
}
