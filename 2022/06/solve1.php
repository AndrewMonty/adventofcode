<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$start = find_start_of_packet_marker($input) + 1;

echo "first marker is after character $start\n";

function find_start_of_packet_marker(string $string): int
{
    $buffer = [];

    foreach (str_split($string) as $index => $char) {
        $buffer[] = $char;

        if (count($buffer) < 4) {
            continue;
        }

        if (count($buffer) > 4) {
            array_shift($buffer);
        }

        $bufferString = implode('', $buffer);

        $uniqueString = count_chars($bufferString, 3);

        if (strlen($uniqueString) == 4) {
            // echo "$index: $char is not in $bufferString\n";
            return $index;
        }

        // echo "$index: $char is in $bufferString\n";
    }

    return -1;
}
