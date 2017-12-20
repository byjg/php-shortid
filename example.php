<?php

require "vendor/autoload.php";

echo \ByJG\Utils\ShortId::fromNumber(81717788171667188198) . "\n";

echo \ByJG\Utils\ShortId::fromNumber(
    81717788171667188198,
    \ByJG\Utils\ShortId::$MAP_NUMBERS_FIRST
) . "\n";
