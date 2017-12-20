<?php

require "vendor/autoload.php";

$result = "";
$origin = preg_replace('/(\w)/', '\1,', \ByJG\Utils\ShortId::$MAP_DEFAULT);
$origin = preg_split('/,/', $origin, -1, PREG_SPLIT_NO_EMPTY);

echo "A\n";
while (count($origin) > 0) {
    $iPos = rand(0, count($origin) - 1);
    $result .= $origin[$iPos];
    unset($origin[$iPos]);
    $origin = array_values($origin);
    echo "$result\n";
}
echo "B\n";
