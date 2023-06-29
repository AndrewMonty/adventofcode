<?php

$handle = fopen(__DIR__ . '/input.txt', 'r');

$totalPriority = 0;

while (!feof($handle) && $contents = fgets($handle)) {
    $compartmentSize = floor(strlen($contents) / 2);
    $compartments = str_split($contents, $compartmentSize);
    
    $left = str_split($compartments[0]);
    $right = str_split($compartments[1]);
    
    foreach ($left as $item) {
        if (in_array($item, $right, true)) {
            $totalPriority += getPriority($item);
            break;
        }
    }
}

echo "Total priority of common items: $totalPriority\n";

function getPriority($item): int
{
    $items = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return strpos($items, $item) + 1;
}