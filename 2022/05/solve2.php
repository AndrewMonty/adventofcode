<?php

$handle = fopen(__DIR__ . '/input.txt', 'r');
$lines = [];

while (!feof($handle) && $line = fgets($handle)) {
    $lines[] = $line;
}

$stacks = array_fill(0, 9, []);

for ($i = 7; $i >= 0; $i--) {
    $stack = 0;
    for ($j = 1; $j <= 33; $j += 4) {
        if ($crate = trim(substr($lines[$i], $j, 1))) {
            $stacks[$stack][] = $crate;
        }
        $stack++;
    }
}

for ($i = 10; $i < 513; $i++) {
    $words = explode(' ', trim($lines[$i]));
    $count = (int) $words[1];
    $origin = (int) $words[3] - 1;
    $destination = (int) $words[5] - 1;
    $crates = [];
    for ($count; $count > 0; $count--) {
        $crates[] = array_pop($stacks[$origin]);
    }
    array_push($stacks[$destination], ...array_reverse($crates));
}

$tallestStack = 0;

foreach ($stacks as $index => $stack) {
    if (count($stack) > $tallestStack) {
        $tallestStack = count($stack);
    }
}

for($tallestStack; $tallestStack > 0; $tallestStack--) {
    $index = $tallestStack - 1;
    foreach ($stacks as $stack) {
        $crate = $stack[$index] ?? ' ';
        echo '[' . $crate . '] ';
    }
    echo "\n";
}
