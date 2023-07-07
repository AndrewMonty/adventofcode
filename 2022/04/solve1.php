<?php

$handle = fopen(__DIR__ . '/input.txt', 'r');

$fullyContainedPairs = 0;

while (!feof($handle) && $line = fgets($handle)) {
    $pairs = explode(',', $line);
    $left = explode('-', $pairs[0]);
    $right = explode('-', $pairs[1]);

    $minLeft = (int) $left[0];
    $maxLeft = (int) $left[1];

    $minRight = (int) $right[0];
    $maxRight = (int) $right[1];

    if ($minLeft <= $minRight && $maxLeft >= $maxRight) {
        $fullyContainedPairs++;
    } elseif ($minRight <= $minLeft && $maxRight >= $maxLeft) {
        $fullyContainedPairs++;
    }
}

echo "Total number of fully contained pairs: $fullyContainedPairs\n";
