<?php

namespace ByJG\ShortId;

use InvalidArgumentException;

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

    public static function fromNumber(int $number, ?string $map = null): string
    {
        if (empty($map)) {
            $map = ShortId::$MAP_DEFAULT;
        }

        $size = strlen($map);
        $result = "";

        while ($number >= $size) {
            $mod = $number % $size;
            $number = intdiv($number, $size);
            $result .= $map[$mod];
        }
        $result .= $map[$number];

        return $result;
    }

    public static function fromHex(string $hex, ?string $map = null): string
    {
        $number = hexdec(str_replace('-', '', $hex));

        // hexdec() returns a float once the value is greater than PHP_INT_MAX
        if (!is_int($number)) {
            throw new InvalidArgumentException(
                "The hex value '$hex' does not fit in an integer (max " . dechex(PHP_INT_MAX) . "). "
                . "Use fromUuid() for longer values."
            );
        }

        return self::fromNumber($number, $map);
    }

    public static function fromUuid(string $hex, ?string $map = null): string
    {
        $numbers = unpack('L*', pack('h*', str_replace('-', '', $hex)));

        if ($numbers === false) {
            $numbers = [];
        }

        $result = "";

        foreach ($numbers as $number) {
            $result .= self::fromNumber($number, $map);
        }

        return $result;
    }

    public static function fromRandom(int $min = 2147483647, int $max = 9223372036854775807, ?string $map = null): string
    {
        $number = rand($min, $max);

        return self::fromNumber($number, $map);
    }

    public static function get(string $shortId, ?string $map = null): int
    {
        if (empty($map)) {
            $map = ShortId::$MAP_DEFAULT;
        }

        $base = strlen($map);
        $result = 0;

        // The first character is the least significant digit, so read from the end. Integer
        // arithmetic only: a float loses precision above 2^53.
        for ($pos = strlen($shortId) - 1; $pos >= 0; $pos--) {
            $digit = intval(strpos($map, $shortId[$pos]));
            if ($result > intdiv(PHP_INT_MAX - $digit, $base)) {
                throw new InvalidArgumentException(
                    "The short id '$shortId' is greater than the largest integer (" . PHP_INT_MAX . ")."
                );
            }
            $result = $result * $base + $digit;
        }

        return $result;
    }
}
