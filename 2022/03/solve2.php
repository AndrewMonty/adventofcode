<?php

$handle = fopen(__DIR__ . '/input.txt', 'r');

$totalPriority = 0;
$group = [];

while (!feof($handle) && $contents = trim(fgets($handle))) {
    $group[] = $contents;
    
    if (count($group) == 3) {
        foreach (str_split($contents) as $item) {
            $inFirstRuckSack = str_contains($group[0], $item);
            $inSecondRuckSack = str_contains($group[1], $item);

            if ($inFirstRuckSack && $inSecondRuckSack) {
                $priority = getPriority($item);
                $totalPriority += getPriority($item);
                // echo "common item: $item, priority: $priority, total: $totalPriority\n";
                break;
            }
        }

        $group = [];
    }
}

echo "Total priority of badge items: $totalPriority\n";

function getPriority($item): int
{
    $items = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return strpos($items, $item) + 1;
}