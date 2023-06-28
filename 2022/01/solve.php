<?php

$handle = fopen(__DIR__ . '/input.txt', 'r');

$list = [];
$elf = [];

while (!feof($handle)) {
    $line = (int) fgets($handle);

    if ($line) {
        $elf[] = (int) $line;
    } else {
        $list[] = $elf;
        $elf = [];
    }
}

foreach ($list as $index => $elf) {
    $calories = array_sum($elf);
    $list[$index] = $calories;
}

arsort($list);

$slice = array_slice($list, 0, 3);

var_dump($slice);
var_dump(array_sum($slice));
