<?php

declare(strict_types = 1);


$test = [
    "1" => "one",
    "two" => "2",
    null => 2,
];
var_dump($test);

var_dump($test[""]);

$keys = array_walk($test, function ($value, $key) {
    var_dump($value);
    return $key;
});

print_r($keys);