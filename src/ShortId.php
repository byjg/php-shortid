<?php

namespace ByJG\ShortId;

class ShortId
{
    public static string $MAP_DEFAULT =
        "abcdefghijklmnopqrstuvwxyz"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
        . "0123456789"
    ;

    public static string $MAP_ALTERNATE =
        "abcdefghijklmnopqrstuvwxyz"
        . "0123456789"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ;

    public static string $MAP_NUMBERS_FIRST =
        "0123456789"
        . "abcdefghijklmnopqrstuvwxyz"
        . "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
    ;

    public static string $MAP_RANDOM =
        "WPyHLMtE74KjUQvBqoS652uADF"
        . "gZibO9RdznT1YIVsXwfkaxCNpr"
        . "J3chmel0G8";

    public static function fromNumber(int $number, string $map = null): string
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

    public static function fromHex(string $hex, string $map = null): string
    {
        $number = hexdec(str_replace('-', '', $hex));

        return self::fromNumber($number, $map);
    }

    public static function fromUuid(string $hex, string $map = null): string
    {
        $numbers = unpack('L*', pack('h*', str_replace('-', '', $hex)));

        $result = "";

        foreach ($numbers as $number) {
            $result .= self::fromNumber($number, $map);
        }

        return $result;
    }

    public static function fromRandom(int $min = 2147483647, int $max = 9223372036854775807, string $map = null): string
    {
        $number = rand($min, $max);

        return self::fromNumber($number, $map);
    }

    public static function get(string $shortId, string $map = null): float|int
    {
        if (empty($map)) {
            $map = ShortId::$MAP_DEFAULT;
        }

        $base = strlen($map);
        $order = 1;
        $result = 0;

        for ($pos = 0; $pos < strlen($shortId); $pos++) {
            $result += intval(strpos($map, $shortId[$pos])) * $order;
            $order *= $base;
        }

        return $result;
    }
}
