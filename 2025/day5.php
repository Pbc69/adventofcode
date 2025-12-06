<?php

$input = file_get_contents('day5.txt');
$input = str_replace("\r", "", $input);
[$ranges, $ids] = explode("\n\n", $input);
$ranges = explode("\n", $ranges);
$ids = explode("\n", $ids);

$fresh = [];
foreach ($ranges as $range) {
    [$start, $end] = explode("-", $range, 2);

    foreach ($ids as $i => $id) {
        if ($id >= $start && $id <= $end) {
            $fresh[] = $id;
            unset($ids[$i]);
            echo "Found id $id\n";
        }
    }
}

echo "fresh: " . count($fresh) . "\n";
