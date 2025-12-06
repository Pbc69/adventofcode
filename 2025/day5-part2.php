<?php

$input = file_get_contents('day5.txt');
$input = str_replace("\r", "", $input);
[$ranges] = explode("\n\n", $input);
$ranges = array_values(array_unique(explode("\n", $ranges)));

foreach ($ranges as $i => $range) {
    [$start, $end] = explode("-", $range, 2);
    $ranges[$i] = [(int)$start, (int)$end];
}

usort($ranges, fn($a, $b) => $a[0] <=> $b[0]);

$merged = [];
$current = array_shift($ranges);

foreach ($ranges as $range) {
    if ($range[0] <= $current[1] + 1) {
        // verschmelzen
        $current[1] = max($current[1], $range[1]);
    } else {
        $merged[] = $current;
        $current = $range;
    }
}
$merged[] = $current;

$fresh = array_sum(array_map(fn($r) => $r[1] - $r[0] + 1, $merged));

print_r($merged);
echo "fresh: $fresh\n";
